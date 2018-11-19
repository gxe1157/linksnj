"use strict";

// the homepage controller
angular.module('linksApp').controller('agentsDetailController',
    function ($scope, linksService, $q, zillowService, $timeout) {

        // vm binding
        var vm = this;

        vm.onLoad = onLoad;
        vm.params = {};
        vm.agent;
        vm.agentProperties = [];
        vm.agentSoldProperties = [];
        vm.agentFunFacts = [];
        vm.loadingProperties = true;
        vm.loadingSoldProperties = true;
        vm.agentReviews = [];
        vm.getAgentReviews = getAgentReviews;

        function getAgentDetails(id) {
            linksService.getAgent(id).then(function (resp) {
                vm.agent = (resp.data.length) ? resp.data[0]: [];
                getAgentProperties(vm.agent.first_name + ' ' + vm.agent.last_name);
                getAgentSoldProperties(vm.agent.first_name + ' ' + vm.agent.last_name);

                getAgentReviews();
            });
        }

        function getAgentFunFacts (id) {
            linksService.getAgentFunFacts(id).then(function (resp) {
                vm.agentFunFacts = (resp.data.length) ? resp.data: [];
            });
        }

        function getAgentReviews () {
            zillowService.getAgentReviews(vm.agent.first_name + ' ' + vm.agent.last_name).then(function (resp){
                if (resp.data.response) {
                    vm.agentReviews = resp.data.response;
                }
            });
        }

        function getAgentSoldProperties(name) {
            linksService.getAgentSoldProperties(name).then(function (resp) {
                vm.agentSoldProperties = resp.data;
                vm.loadingSoldProperties = false;
            }, function (errors) {
                vm.loadingSoldProperties = false;
                console.error(errors);
            })
        }

        function getAgentProperties(name) {
            var getRes = linksService.getAgentProperties(name);
            var getRnt = linksService.getAgentRntProperties(name);

            $q.all([getRes,getRnt]).then(function (resp) {
                var res = (resp[0].data.length) ? resp[0].data: [];
                var res1 = (resp[1].data.length) ? resp[1].data: [];

                vm.agentProperties = res.concat(res1);

            }, function (errors) {
                console.error(errors);
            }).finally(function() {
                vm.loadingProperties = false;
            });
        }

        function onLoad() {


            $timeout(function() {

                $(".schedule-maker .btn-primary").click();

            }, 10000);

            var urlParams = window.location.search.slice(1)

                .split('&')

                .reduce(function _reduce(/*Object*/ a, /*String*/ b) {

                    b = b.split('=');

                    a[b[0]] = decodeURIComponent(b[1]);

                    return a;

                }, {});



            // set url params

            vm.params = urlParams;
            getAgentDetails(vm.params.id);
            getAgentFunFacts(vm.params.id);
        };

        // onload / constructor
        vm.onLoad();
    });