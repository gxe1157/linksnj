"use strict";
// the homepage controller
angular.module('linksApp').controller('buyAHomeController',
    function ($scope, linksService, $window) {

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
            linksService.getRecentResidentials(vm.recentAmount).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
                matchHeight(".col-sm-12.col-lg-4 .property-item", 10);
            }, function (err) {
                console.error(err);
            });
        }


        function onLoad() {
            loadProperties();
            linksService.getListingTotalsWithinWeeks('rets_res', 2, '').then(function (resp) {
                vm.totalPropsTwoWeeks = resp.data;
            });

            linksService.getListingTotalsWithinDays('rets_res', 1, '').then(function (resp) {
                vm.totalPropertiesToday = resp.data;
            });

            linksService.getListingTotalsWithinWeeks('rets_res', 1, '').then(function (resp) {
                vm.totalProps = resp.data;
            });

            linksService.getListingTotalsWithinWeeksSold('rets_res_sold', 4).then(function (resp) {
                vm.soldThisMonth = resp.data;
            });
        };
        
        // onload / constructor
        vm.onLoad();
    });