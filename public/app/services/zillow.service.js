"use strict";

angular.module('linksApp').factory('zillowService', function ($http) {

    var apiKey = 'X1-ZWz18pf2ztlr0r_1zmzq';
    var reviewsApiEndpoint = 'https://www.zillow.com/webservice/ProReviews.htm?zws-id='+apiKey;
    var chartApiEndpoint = 'http://www.zillow.com/webservice/GetChart.htm?zws-id='+apiKey;
    var output = '&output=json';
    return {
        getAgentReviews: function (agentName) {
            return $http.get(reviewsApiEndpoint + '&screenname='+agentName + output);
        },
        getPropertyChart : function (zpid) {
          return $http.get(chartApiEndpoint + '&unit-type=percent&zpid=' + zpid + '&width=600&height=300' + output);
        }
    }
});