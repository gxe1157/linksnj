"use strict";

angular.module('linksApp').factory('userService', function () {

    var apiEndpoint = 'linksnj.com/index.php/api/';

    return {
        // gets a set amount of properties
        getUsers: function (amount) {
            return $http.get(apiEndpoint + 'GetProperties/' + amount);
        }
    }
});