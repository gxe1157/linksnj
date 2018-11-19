"use strict";
// the homepage controller
angular.module('linksApp').controller('rentalController',
    function ($scope, linksService) {

        // controller as syntax 
        var vm = this;
        vm.onLoad = onLoad;

        // setup + config
        vm.loading = true;
        vm.recentAmount = 12;
        vm.totalProps = '';
        vm.totalAdded = '';

        // api response
        vm.properties = [];

        function loadProperties() {
            vm.loading = true;
            vm.properties = [];
            linksService.getRecentRentals(vm.recentAmount).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
                matchHeight(".col-sm-12.col-lg-4 .property-item", 10);
            }, function (err) {
                console.error(err);
            });
        }


        function onLoad() {
            loadProperties();
            linksService.getListingTotals('rets_rnt').then(function (resp) {
                vm.totalProps = resp.data.length;
            });
            linksService.getListingTotalsWithinWeeks('rets_rnt', 1).then(function (resp) {
                vm.totalAdded = resp.data;
            });

        };

        // onload / constructor
        vm.onLoad();
    });