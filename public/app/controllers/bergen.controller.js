"use strict";

// the homepage controller
angular.module('linksApp').controller('propertiesController',
    function ($scope, linksService) {

        // controller as syntax 
        var vm = this;

        vm.onLoad = onLoad;
        vm.changeSort = changeSort;
        vm.loadRentals = loadRentals;
        vm.loadResidentials = loadResidentials;
        vm.loadProperties = loadProperties;
        vm.paginate = paginate;

        vm.loading = true;
        vm.county = 'BERGEN';
        vm.type = 'RES';
        vm.selectedTown = null;

        // pagination properties
        vm.total = null;
        vm.offset = 0;
        vm.offIncrement = 10;

        // api response + config
        vm.properties = [];
        vm.availableTowns = [];

        // search config
        vm.searchConfig = {
            orderBy: 'DTADD',
            sortByAsc: false
        }

        function changeSort(sortModel) {
            if (!sortModel) return;
            sortModel = sortModel.split(",");

            // on sort change reset pagination
            vm.offset = 0;

            try {
                vm.searchConfig.orderBy = sortModel[0];
                vm.searchConfig.sortByAsc = sortModel[1];
                loadProperties();
            } catch (e) {
                console.error(e);
            }
        }

        function paginate(offsetAmt) {
            if (vm.offset >= 0) {
                vm.offset += offsetAmt;
            }
            loadProperties();
        }

        function loadProperties() {
            if (vm.type == 'RES') {
                loadResidentials();
            } else {
                loadRentals();
            }
        }

        function loadResidentials() {
            vm.loading = true;
            vm.properties = [];
            vm.type = 'RES';
            linksService.getResidentialProperties(vm.searchConfig.orderBy, vm.offset, vm.searchConfig.sortByAsc, vm.county, vm.selectedTown).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
                countTotal();
                getGeoCodesFromProperties();
            }, function (err) {
                console.error(err);
            });
        }

        function loadRentals() {
            vm.loading = true;
            vm.properties = [];
            vm.type = 'RNT';
            linksService.getRentalProperties(vm.searchConfig.orderBy, vm.offset, vm.searchConfig.sortByAsc, vm.county, vm.selectedTown).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
                countTotal();
                getGeoCodesFromProperties();
            }, function (err) {
                console.error(err);
            });
        }

        function getGeoCodesFromProperties() {
            var geocodeMarkers = vm.properties.map(function(property) {
                var marker = ({
                    name: "test",
                    location: [property.latX, property.longY]
                });
                return marker;
            });
            // push property markers to the map
            window.addMapPoints(geocodeMarkers);
        }

        function countTotal() {
            if (vm.properties.length) {
                vm.total = vm.properties[0].total;
            } else {
                vm.total = 0;
            }
        }

        function getAvailableTowns() {
            linksService.getAvailableTownsByCounty(vm.county).then(function (resp) {
                vm.availableTowns = resp.data.map(town => town.AREANAME);
                vm.availableTowns.unshift(null);
            }, function (err) {
                console.error(err);
            });
        }

        function onLoad() {
            loadResidentials();
            getAvailableTowns();
        };

        // onload / constructor
        vm.onLoad();
    });