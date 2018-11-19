(function () {
    'use strict';
    angular.module('linksApp').controller('recentPropertiesController', function ($scope, linksService) {

        // controller as syntax 
        var vm = this;
        vm.onLoad = onLoad;
        vm.loading = true;
        vm.recentLoading = true;
        vm.recentAmount = 3;

        // params 
        vm.params = {
            type: '',
            id: ''
        }

        // api response + config
        vm.recentProps = [];

        function loadRelatedListings() {
            // get recent properties
            linksService.getRecentResidentials(vm.recentAmount).then(function (resp) {
                vm.recentLoading = false;
                vm.recentProps = resp.data;

            }, function (err) {
                console.error(err);
            });
        }

        function onLoad() {
            loadRelatedListings();
        };

        // onload / constructor
        vm.onLoad();
    });
})();