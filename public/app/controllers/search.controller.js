"use strict";

// the homepage controller
angular.module('linksApp').controller('searchController', function ($scope, linksService, $timeout) {
        // controller as syntax 
        var vm = this;
        vm.autoComplete = [];
        vm.searchProperty = searchProperty;
        vm.loading = false;
        vm.searchQuery = "";
        vm.bedrooms = 'A';
        vm.baths = 'A';
        vm.bathsPart = 'A';

        var grabTown = $timeout(function(){
            if(window['currentTown'] !== 'undefined') {
                vm.searchQuery = window['currentTown'];
                $timeout.cancel(grabTown);
            }
        }, 250);

        function searchProperty (name) {
            if(!name) return;
            vm.loading = true;
            //
            // linksService.search(name).then(function(resp){
            //     vm.autoComplete = resp.data;
            //     vm.loading = false;
            // });

            linksService.addressSearch(name).then(function(resp){
                vm.autoComplete = resp.data;
                vm.loading = false;
            });
        };

    });