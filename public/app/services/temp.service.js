"use strict";

angular.module('linksApp').factory('linksService', function ($http) {
    
    var googleApiKey = 'AIzaSyAxjcSJOhoMWUJdX7BKMM4nfN8zCJhMfMY';
    var apiEndpoint = 'http://s223809.gridserver.com/index.php/api/';
    var dynamicApiEndpoint = 'http://s223809.gridserver.com/phprets/';
    var googleGeoCode = 'https://maps.googleapis.com/maps/api/geocode/json?address=';

    return {

        // 2.0 | gets a set amount of properties t
        getResidentialProperties: function (orderBy, offset, sortByAsc) {
            // map the sort boolean for sql
            sortByAsc = (sortByAsc == 'false') ? "DESC" : "ASC";
            return $http.get(apiEndpoint + 'GetResidentialProperties/' + orderBy + "/" + offset + "/" + sortByAsc);
        },
        // 2.0 | gets a set amount of properties 
        getRentalProperties: function (orderBy, offset, sortByAsc) {
            // map the sort boolean for sql
            sortByAsc = (sortByAsc == 'false') ? "DESC" : "ASC";
            return $http.get(apiEndpoint + 'GetRentalProperties/' + orderBy + "/" + offset + "/" + sortByAsc);
        },
        // 2.0 | gets recent residentials ordered by dtadded
        getRecentResidentials(amount) {
            return $http.get(apiEndpoint + 'getRecentResidentials/' + amount);
        },
        // 2.0 | gets recent rentals ordered by dtadded
        getRecentRentals(amount) {
            return $http.get(apiEndpoint + 'getRecentRentals/' + amount);
        },

        getGeoCodes(amount) {
            return $http.get(apiEndpoint + 'GetGeoCodes/' + amount);
        },

        // get properties for county
        getCountyProperties: function (county, type, offset) {
            return $http.get(dynamicApiEndpoint + 'get_properties/' + type + '/county/' + county + "/" + offset);
        },
        // get recents properties
        getRecentProperties: function (amount) {
            return $http.get(dynamicApiEndpoint + 'getMapGeoCodes/' + type + '/county/' + county + "/" + offset);
        },
        // gets an individual property by retsId
        getPropertyById: function (type,id) {
            return $http.get(dynamicApiEndpoint + 'get_property/' + type + "/" + id);
        },
        getPropertiesWithoutPhotos: function (county, type, offset) {
            return $http.get(dynamicApiEndpoint + 'get_properties_nophoto/' + type + '/county/' + county + "/" + offset);
        },
        geoCodeAddress: function(address) {
            var formattedAddress = address.strReplace(" ","+");
            return $http.get(googleGeoCode + 'formattedAddress&=key' + googleApiKey);
        },
        searchPropertyByName: function (name) {
            return $http.get(apiEndpoint + 'SearchPropertyName/' + name);
        }
    }
});