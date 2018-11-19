"use strict";

// the homepage controller
angular.module('linksApp').controller('propertiesController',
    function ($scope, linksService) {

        // controller as syntax 
        var vm = this;
        vm.onLoad = onLoad;
        vm.loading = false;
        
        // api response + config
        vm.properties = [];
        vm.propertyAmount = 10;
        
        vm.searchObj = {
            rentalInput: "!!"
        };

        // slider config obj
        vm.sliderObj = {
            min: 0,
            max: 0
        };

        function setPriceMax () {
            // es6 find max
            var priceArray = resp.data.array.forEach(p => p.listPrice);
            vm.sliderObj.max = Math.max(priceArray);
        };

        function onLoad() {
            vm.loading = true;
            linksService.getProperties(vm.propertyAmount).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
            }, function(err) {
                console.error(err);
            });
        };        
        
        // onload / constructor
        vm.onLoad();
});