"use strict";

// the homepage controller
angular.module('linksApp').controller('agentsController',
    function ($scope, linksService, $window) {

        // vm binding
        var vm = this;

        vm.onLoad = onLoad;
        vm.goToLink = goToLink;
        vm.agents = [];
        vm.notLoading;

        function getAgents() {
            linksService.getAgents().then(function (resp) {

                for(var i=0 ; i < resp.data.length; i++) {
                    if(!resp.data[i].avatar_name) {
                        resp.data[i].avatar_name = "profile-avatar.png";
                    }
                }
                vm.agents = resp.data;

            }).finally(function(){
                vm.notLoading = true;
            });
        }

        function goToLink(agentId) {
            $window.location.href = 'http://linksnj.com/agent-detail?id=' + agentId;
        }

        function onLoad() {
            getAgents();
        };

        // onload / constructor
        vm.onLoad();
    });