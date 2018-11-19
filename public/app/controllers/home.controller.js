"use strict";
// the homepage controller
angular.module('linksApp').controller('homepageController',
    function ($scope, linksService, $window, $interval, $q) {

        // controller as syntax 
        var vm = this;
        vm.onLoad = onLoad;

        // setup + config
        vm.loading = true;
        vm.loadingRecent = true;
        vm.recentTownListingsLoading = true;
        vm.recentAmount = 4;

        // api response
        vm.properties = [];
        vm.recent = [];
        vm.rentAmounts = [];
        vm.buyAmounts = [];
        vm.totalRentals = 0;
        vm.totalResidentials = 0;
        vm.mapFilter = mapFilter;
        vm.homeTownProperties = [];
        vm.currentCounty = "";
        vm.secondLoadToInitializeMap = false;
        vm.staticTowns = ["ALL", "Alpine", "Bayonne", "Bergenfield", "Bloomfield", "Cedar Grove", "Cliffside Park", "Clifton", "Closter", "Cresskill", "Demarest", "Edgewater", "Edison", "Elizabeth", "Elmwood Park", "Emerson", "Englewood", "Englewood Cliffs", "Fair Lawn", "Fairfield", "Fort Lee", "Franklin Lakes", "Glen Rock", "Guttenberg", "Hackensack", "Hasbrouck Heights", "Haworth", "Hawthorne", "Hillsdale", "Ho-Ho-Kus", "Hoboken", "Jersey City", "Kearny", "Kinnelon Borough", "Leonia", "Linden", "Little Falls", "Little Ferry", "Lodi", "Lyndhurst", "Mahwah", "Maywood", "Metuchen", "Midland", "Montclair", "Montvale", "Moonachie", "Newark", "New Brunswick", "New Milford", "North Arlington", "North Bergen", "Northvale", "Nutley", "Oakland", "Oradell", "Palisades Park", "Paramus", "Passaic", "Paterson", "Perth Amboy", "Ramsey", "Ridgefield", "Ridgefield Park", "Ridgewood", "River Edge", "Rochelle Park", "Rutherford", "Saddle River", "Secaucus", "Teaneck", "Tenafly", "Totowa", "Union", "Union City", "Upper Saddle River", "Waldwick", "Wayne", "Weehawken", "West New York", "West Orange", "Westwood", "Woodbridge", "Woodcliff Lake", "Woodridge", "Wyckoff"];
        vm.rv = vm.staticTowns;

        function loadGeoCode (towns) {
            vm.properties = [];
            linksService.getGeoCodes(500,towns).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data.map(function(p) {
                    var marker = ({
                        id: p.LISTINGID,
                        type: 'RES',
                        townarea: p.AREANAME,
                        name: p.STREETNUM + " " + p.STREET + " " + p.STREETTYP + ", " + p.AREANAME,
                        photo:  p.photos,
                        propType:  parseInt(p.PROPTYPE) - 1,
                        location: [p.latX, p.longY]
                    });
                    return marker;
                });

                // call the global google maps function to append the new markers from the geocodes
                window.addMapPoints(vm.properties, vm.secondLoadToInitializeMap);

                var roughBoundsX = [];
                var roughBoundsY = [];

                if (window['markers'] && towns) {
                    for (var i = window['markers'].length; i--;) {
                         var test = window['markers'][i].town;
                        if (window['markers'][i].town === towns && towns !== "ALL") {
                            window['markers'][i].setVisible(true);
                            roughBoundsX.push(window['markers'][i].getPosition().lat());
                            roughBoundsY.push(window['markers'][i].getPosition().lng());
                        } else if (window['markers'][i].towns !== towns && towns !== "ALL") {
                            window['markers'][i].setVisible(false);
                        } else {
                            window['markers'][i].setVisible(true);
                            roughBoundsX.push(window['markers'][i].getPosition().lat());
                            roughBoundsY.push(window['markers'][i].getPosition().lng());
                        }
                    }
                }
                vm.secondLoadToInitializeMap = true;

            }, function (err) {
                console.error(err);
            });
        }



        function loadProperties() {
            vm.loading = true;
            vm.loadingRecent = true;

            loadGeoCode();

            // grab properties in user's county
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    // attempt to get user's location
                    linksService.getLocation(position.coords.latitude, position.coords.longitude).then(function (response) {
                        vm.currentLocation = response.data.results;

                        if(!vm.currentLocation.length) {
                            loadRecent();
                            return false;
                        }

                        var add = vm.currentLocation;

                        // GET TOWN
                        for (var i=0; i < add.length; i++) {
                            var curr = add[i].address_components;
                            for (var c=0; c < curr.length; c++) {
                                if(curr[c].types.includes("locality") && curr[c].short_name) {
                                    vm.currentTown = curr[c].short_name;
                                    window['currentTown'] = vm.currentTown;
                                    break;
                                }
                            }
                        }

                        // GET COUNTY
                        for (var i=0; i < add.length; i++) {
                            var curr = add[i].address_components;
                            for (var c=0; c < curr.length; c++) {
                                if(curr[c].types.includes("political") && curr[c].short_name.includes("County")) {
                                    vm.currentCounty = curr[c].short_name.replace(" County", "");
                                    break;
                                }
                            }
                        }


                        // get town listings
                        townListings();

                        // get county listings
                        linksService.getResidentialProperties('DTADD', 0, 'DESC', vm.currentCounty, 'A', 10, 'A', 'A', 'A').then(function (resp) {
                            vm.recent = resp.data.slice(0,4);
                            vm.loadingRecent = false;
                            matchHeight(".col-sm-12.col-lg-3 .property-item", 10);
                        }, function (err) {
                            loadRecent();
                        });

                    });
                });
            } else {
                loadRecent();
            }
        }

        // get town listings
        function townListings() {
            $q.all( [linksService.getRentalProperties('DTADD', 0, 'DESC', vm.currentCounty, vm.currentTown),
                    linksService.getResidentialProperties('DTADD', 0, 'DESC', vm.currentCounty, vm.currentTown)]).then(function(resp) {
                        vm.recentTownListings = resp[0].data.concat(resp[1].data).slice(0,4);
                        vm.recentTownListingsLoading = false;
            })
        }

        function loadRecent() {
            // get recent properties
            linksService.getRecentResidentials(vm.recentAmount).then(function (resp) {
                vm.recent = resp.data;
                // match heights of properties
                matchHeight(".property-item-module .property-item", 10);
            }, function (err) {
                console.error(err);
            }, function() {
                vm.loadingRecent = false;
            });
        }

        function mapFilter(town) {
            loadGeoCode(town);
        }

        function getListingTotals() {
            // get recent properties
            linksService.getListingTotals(vm.type).then(function (resp) {
                vm.recent = resp.data;
            }, function (err) {
                console.error(err);
            }, function () {
                vm.loadingRecent = false;
            });
        }

        function onLoad() {
            loadProperties();
            linksService.getGrandLiveListingTotals(vm.type).then(function (resp) {
                // because we bring back ALL totals combine them
                vm.buyAmounts = resp.data.map(r => parseInt(r.data)).reduce((a,b) => a+b);
            });
            linksService.getListingTotalsWithinWeeks('rets__sold', 4).then(function (resp) {
                vm.soldTotals = resp.data;
            });
            linksService.getListingTotals('rets_rnt').then(function (resp) {
                vm.rentAmounts = resp.data.length;
            });
        };
        
        // onload / constructor
        vm.onLoad();
    });