"use strict";

// the homepage controller

angular.module('linksApp').controller('profileController',

    function ($scope, linksService, CURRENT_USER_ID) {

        // controller as syntax
        var vm = this;
        vm.favoriteProperties = [];
        vm.favoritesLoading = false;

        function getFavorites() {
            vm.favoritesLoading = true;
            linksService.getFavorites(CURRENT_USER_ID).then(function (resp) {
                vm.favoriteProperties = resp.data;
            }).finally(function () {
                vm.favoritesLoading = false;
            });
        };

        function onit() {
            getFavorites();
        }

        // on load
        onit();
});
