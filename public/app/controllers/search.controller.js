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
        vm.availableTownsFromSearch = [];
        vm.availableCountiesFromSearch = [];
        vm.searchType = 'res';

        var grabTown = $timeout(function(){
            if(window['currentTown'] !== 'undefined') {
                vm.searchQuery = window['currentTown'];
                $timeout.cancel(grabTown);
            }
        }, 250);

        function searchProperty (name) {
            if(!name) return;
            vm.loading = true;

            linksService.addressSearch(name, 'rets_' + vm.searchType).then(function(resp){
                vm.autoComplete = resp.data;
                // get towns
                vm.availableTownsFromSearch = resp.data.map((t) => { return {town: t.AREANAME, county: t.COUNTY }});
                vm.availableTownsFromSearch = removeDuplicates (vm.availableTownsFromSearch, "town");

                // get counties
                vm.availableCountiesFromSearch = resp.data.map((t) => { return {town: t.AREANAME, county: t.COUNTY }});
                vm.availableCountiesFromSearch = removeDuplicates (vm.availableCountiesFromSearch, "county");

                vm.loading = false;
            });
        };

        function removeDuplicates(myArr, prop) {
            return myArr.filter((obj, pos, arr) => {
                return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
            });
        }
});