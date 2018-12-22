"use strict";

// the homepage controller
angular.module('linksApp').controller('townController',
    function ($scope, linksService, $location) {

        // controller as syntax
        var vm = this;

        vm.onLoad = onLoad;
        vm.changeSort = changeSort;
        vm.loadRentals = loadRentals;
        vm.loadResidentials = loadResidentials;
        vm.loadProperties = loadProperties;
        vm.paginate = paginate;
        vm.resetPagination = resetPagination;

        // state
        vm.state = $location.search();
        vm.loading = true;
        vm.countLoading = true;
        vm.type = 'res';

        // grab params from $state
        vm.selectedTown = vm.state.town || 'All Towns';
        vm.county = vm.state.county || 'ESSEX';
        vm.bedrooms = vm.state.beds || 'A';
        vm.baths = vm.state.baths || 'A';
        vm.bathsPart = vm.state.bathsPart || 'A';
        vm.priceMin = vm.state.priceMin || null;
        vm.priceMax = vm.state.priceMax || null;

        // pagination properties
        vm.total = null;
        vm.totalPages = 0;
        vm.currentPage = 1;
        vm.offset = 0;
        vm.offIncrement = 6;



        // api response + config
        vm.properties = [];
        vm.availableTowns = [];

        // search config
        vm.searchConfig = {
            orderBy: 'DTADD',
            sortByAsc: 'false'
        }

        function changeSort(sortModel) {
            if (!sortModel) return;
            sortModel = sortModel.split(",");

            // on sort change reset pagination
            resetPagination();

            try {
                vm.searchConfig.orderBy = sortModel[0];
                vm.searchConfig.sortByAsc = sortModel[1];
                loadProperties();
            } catch (e) {
                console.error(e);
            }
        }

        function paginate(offsetAmt, currPage) {
            // get total pages
            vm.totalPages = Math.ceil(vm.totalProps / vm.offIncrement);
            if (vm.offset >= 0) {
                vm.offset += offsetAmt;
                vm.currentPage += currPage;
            }
            loadProperties();
        }

        function resetPagination() {
            vm.offset = 0;
            vm.currentPage = 1;
        }

        function loadProperties() {

            // update selected account type $state
            $location.search('town', vm.selectedTown).replace();
            $location.search('county', vm.county).replace();
            $location.search('beds', vm.bedrooms).replace();
            $location.search('baths', vm.baths).replace();
            $location.search('bathsPart', vm.bathsPart).replace();
            $location.search('priceMin', vm.priceMin).replace();
            $location.search('priceMax', vm.priceMax).replace();

            vm.totalProps = '';

            // safeguard against null town selection and replace with readable human "all"
            var safeSelectedTown = (vm.selectedTown === 'All Towns') ? null : vm.selectedTown;

            if (vm.type == 'res') {
                loadResidentials(safeSelectedTown);
            } else {
                loadRentals(safeSelectedTown);
            }
        }

        function loadResidentials(town) {
            vm.loading = true;
            vm.properties = [];
            vm.type = 'res';
            linksService.getResidentialProperties(vm.searchConfig.orderBy, vm.offset, vm.searchConfig.sortByAsc, vm.county, town, vm.offIncrement, vm.baths, vm.bathsPart, vm.bedrooms, vm.priceMin, vm.priceMax).then(function (resp) {
                vm.loading = false;
                vm.properties = resp.data;
                countTotal();
                getGeoCodesFromProperties();
            }, function (err) {
                console.error(err);
            });
        }

        function loadRentals(town) {
            vm.loading = true;
            vm.properties = [];
            vm.type = 'rnt';

            // update selected account type $state
            $location.search('town', vm.selectedTown).replace();
            $location.search('county', vm.county).replace();

            vm.totalProps = '';

            // safeguard against null town selection and replace with readable human "all"
            var safeSelectedTown = (vm.selectedTown === 'All Towns') ? null : vm.selectedTown;

            linksService.getRentalProperties(vm.searchConfig.orderBy, vm.offset, vm.searchConfig.sortByAsc, vm.county, town, vm.offIncrement, vm.baths, vm.bathsPart, vm.bedrooms, vm.priceMin, vm.priceMax).then(function (resp) {
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
                    id: property.LISTINGID,
                    type: vm.type,
                    name: property.STREETNUM + " " + property.STREET + " " + property.STREETTYP + ", " + property.AREANAME,
                    photo: property.photos,
                    location: [property.latX, property.longY]
                });
                return marker;
            });
            // push property markers to the map
            window.addMapPoints(geocodeMarkers, true);
        }

        function countTotal() {
            var safeSelectedTown = (vm.selectedTown === 'All Towns') ? '' : vm.selectedTown;
            vm.countLoading = true;
            linksService.getListingTotals('rets_' + vm.type, vm.county, safeSelectedTown, vm.baths, vm.bathsPart, vm.bedrooms, vm.priceMin, vm.priceMax).then(function (resp) {
                vm.totalProps = resp.data.length;
                vm.countLoading = false;
                vm.totalPages = Math.ceil(vm.totalProps / vm.offIncrement);
            });
        }

        function onLoad() {
            loadProperties();
        }

        // onload / constructor
        vm.onLoad();
    });