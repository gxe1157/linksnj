"use strict";



// the homepage controller

angular.module('linksApp').controller('pageController',

    function ($scope, linksService, $timeout, zillowService, CURRENT_USER_ID) {

        var popupWindowTimer = 10000;

        // controller as syntax 

        var vm = this;

        vm.onLoad = onLoad;

        vm.agentDetails;

        vm.loading = true;

        vm.recentLoading = true;

        vm.recentAmount = 6;

        vm.favorite = favorite;

        vm.isFavorited = false;
        // params

        vm.params = {

            type: '',

            id: ''

        }



        vm.possibleDatesAmt = 12;



        // api response + config

        vm.property = [];

        vm.recent = [];

        vm.dates = [];


        function loadRelatedListings() {

            // get recent properties

            var client = (vm.params.type === 'RES') ? linksService.getResidentialProperties : linksService.getRentalProperties;

            client('DTADD', 0, 'DESC', vm.property.COUNTY, vm.property.AREANAME, 10, 'A', 'A', 'A').then(function (resp) {

                vm.recent = resp.data.slice(0,6);

                vm.recentLoading = false;

            }, function (err) {

                console.error(err);

            });

        }



        function loadProperty(type, id) {

            vm.loading = true;

            vm.property = [];

            linksService.getPropertyById(id, type).then(function (resp) {

                vm.loading = false;

                vm.property = resp.data.length ? resp.data[0] : resp.data[0];

                // get geocodes from the properties to populate the map

                getGeoCodesFromProperties();

                // load related properties

                loadRelatedListings();

                // format timestamps

                vm.property.DTADD = moment(vm.property.DTADD).format('MMM DD, YYYY');
                vm.property.OPENDATE = moment(vm.property.OPENDATE).format('MMMM DD, YYYY');
                vm.property.openDateIsLaterThanToday = moment(vm.property.OPENDATE).isAfter(moment()); // true

                vm.loadingPhotos = true;

                // check if property was favorited

                getFavorite();

                // load images for property
                linksService.getPhotosById(type, id).then(function (resp) {

                    vm.property.additionalPhotos = resp.data;

                    vm.loadingPhotos = false;

                    loadAgentAvatar();

                    carouselNewUp();

                }, function (err) {
					vm.loadingPhotos = false;
					carouselNewUp();
                	console.error(err);
            	});
        	}
		)};

        function loadAgentAvatar () {
            linksService.getAgentAvatar(vm.property.LAG1NAME.split(" ")[1]).then(function (resp) {
                vm.agentDetails = resp.data.length > 0 ? resp.data[0] : [];
            }, function (err) {
                console.error(err);
            });
        }

	
		function carouselNewUp() {
		  $timeout(function() {
				window.owlCarousel();
			}, 1000);		
		}


        function generateDates() {

            var today = new Date();

            for (var i = 0; i < vm.possibleDatesAmt; i++) {
                vm.dates.push(moment(today).add(i, 'days').format('MMM Do'));
            }

            $timeout(function() {

                window.schedule()

            }, 1000);

        }

        function getFavorite () {
            vm.favoriteLoading = true;
            linksService.getFavorite(vm.currentUserId , vm.property.LISTINGID).then(function(resp){
                vm.isFavorited = (resp.data.length > 0);
            }, function () {
                console.error("error");
            }).finally(function(){
                vm.favoriteLoading = false;
            })
        }


        function favorite (userId,property) {
            vm.favoriteLoading = true;

            var favoriteMethod =  linksService.favoriteProperty;
            if (vm.isFavorited) {
                favoriteMethod = linksService.unFavoriteProperty;
            }

            favoriteMethod(vm.currentUserId , vm.property.LISTINGID).then(function(resp){
                vm.isFavorited = resp.data;
            }, function () {
                console.error("error");
            }).finally(function(){
                vm.favoriteLoading = false;
            })
        }


        function getGeoCodesFromProperties() {

            if (!vm.property.latX || vm.property.latY) return;

            var marker = ({

                id: vm.property.LISTINGID,

                type: vm.type,

                name: vm.property.STREETNUM + " " + vm.property.STREET + " " + vm.property.STREETTYP + ", " + vm.property.AREANAME,

                photo: vm.property.photos,

                location: [vm.property.latX, vm.property.longY]

            });



            // push property markers to the map

            window.addMapPoints([marker], true);

        }





        function onLoad() {

            // load popup window

            $timeout(function() {

                $(".schedule-maker .btn-primary").click();

            }, popupWindowTimer);

            var urlParams = window.location.search.slice(1)

                .split('&')

                .reduce(function _reduce(/*Object*/ a, /*String*/ b) {

                    b = b.split('=');

                    a[b[0]] = decodeURIComponent(b[1]);

                    return a;

                }, {});



            // set url params 

            vm.params = urlParams;

            // get current user id
            vm.currentUserId = CURRENT_USER_ID;

            // generate dates for scheduling

            generateDates();


            // load properties

            console.error(vm.params.type);

            loadProperty(vm.params.type, vm.params.id);

        };        

        

        // onload / constructor

        vm.onLoad();

});