"use strict";

// the homepage controller
angular.module('linksApp').controller('openHouseController',
    function ($scope, linksService) {

        // vm binding
        var vm = this;
        vm.loading = true;
        vm.getOpenHouses = getOpenHouses;

        vm.staticTowns = ["Alpine", "Bayonne", "Bergenfield", "Bloomfield", "Cedar Grove", "Cliffside Park", "Clifton", "Closter", "Cresskill", "Demarest", "Edgewater", "Edison", "Elizabeth", "Elmwood Park", "Emerson", "Englewood", "Englewood Cliffs", "Fair Lawn", "Fairfield", "Fort Lee", "Franklin Lakes", "Glen Rock", "Guttenberg", "Hackensack", "Hasbrouck Heights", "Haworth", "Hawthorne", "Hillsdale", "Ho-Ho-Kus", "Hoboken", "Jersey City", "Kearny", "Kinnelon", "Leonia", "Linden", "Little Falls", "Little Ferry", "Lodi", "Lyndhurst", "Mahwah", "Maywood", "Metuchen", "Midland", "Montclair", "Montvale", "Moonachie", "Newark", "New Brunswick", "New Milford", "North Arlington", "North Bergen", "Northvale", "Nutley", "Oakland", "Oradell", "Palisades Park", "Paramus", "Passaic", "Paterson", "Perth Amboy", "Ramsey", "Ridgefield", "Ridgefield Park", "Ridgewood", "River Edge", "Rochelle Park", "Rutherford", "Saddle River", "Secaucus", "Teaneck", "Tenafly", "Totowa", "Union", "Union City", "Upper Saddle River", "Waldwick", "Wayne", "Weehawken", "West New York", "West Orange", "Westwood", "Woodbridge", "Woodcliff Lake", "Woodridge", "Wyckoff"];
        vm.rv = vm.staticTowns;

        vm.openHouses = [];

        function getOpenHouses() {
            linksService.getUpcomingOpenHouses().then(function (resp) {
                vm.openHouses = resp.data;
                vm.properties = vm.openHouses.map(function(p) {
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
                window.addMapPoints(vm.properties, true);

            }).finally(function(){
                vm.loading = false;
            });
        }

        // onload / constructor
        function onLoad() {
            getOpenHouses();
        }
        onLoad();
    });