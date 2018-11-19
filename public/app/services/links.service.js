"use strict";

angular.module('linksApp').factory('linksService', function ($http) {
    
    var googleApiKey = 'AIzaSyAt059eRF2ThiE1WmyavE2x2mUOIUAW8xc';
    var apiEndpoint = 'https://linksnj.com/index.php/api/';
    var phretsAPIEndpoint = 'https://linksnj.com/phprets/';
    var googleGeoCode = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
    var googleApi = "AIzaSyCFPC2GbdXz-UxeaP8b0gul84e_UPaO7x0";
    var googleLocation = "https://maps.googleapis.com/maps/api/geocode/json?latlng="

    return {
        // 2.0 | get all user agents
        getAgents : function () {
            return $http.get(apiEndpoint + 'GetAgents');
        },
        getAgentNames : function () {
            return $http.get(apiEndpoint + 'GetAgentNames');
        },
        // 2.0 | get all user agents
        getAgent : function (id) {
            return $http.get(apiEndpoint + 'GetAgent/' + id);
        },
        // 2.0 | find properties by last name
        getAgentProperties: function (name) {
            return $http.get(apiEndpoint + 'GetPropertiesByAgentName/' + name);
        },
        getAgentSoldProperties: function (name) {
            return $http.get(apiEndpoint + 'GetSoldPropertiesByAgentName/' + name);
        },
        getAgentAvatar: function (lastName) {
            return $http.get(apiEndpoint + 'GetAgentAvatar/' + lastName);
        },
        getAgentRntProperties: function (name) {
            return $http.get(apiEndpoint + 'GetPropertiesByAgentRNTName/' + name);
        },
        getMonths: function (name) {
            return $http.get(apiEndpoint + 'GetMonths/');
        },
        favoriteProperty: function (userId, property) {
            return $http.post(apiEndpoint + 'FavoriteProperty/' + userId + '/' + property);
        },
        unFavoriteProperty: function (userId, property) {
            return $http.post(apiEndpoint + 'UnFavoriteProperty/' + userId + '/' + property);
        },
        getFavorite: function (userId, property)  {
            return $http.get(apiEndpoint + 'GetFavorite/' + userId + '/' + property);
        },
        getFavorites: function (userId) {
            return $http.get(apiEndpoint + 'GetFavorites/' + userId);
        },
        getRecentPosts: function () {
            return $http.get(apiEndpoint + 'getRecentPosts/');
        },
        getPropertyByRooms: function (baths,bathsfull,bdrms,limit,offset) {
            return $http.get(apiEndpoint + 'getPropertyByRooms/' + '/' + baths + '/' + bathsfull + '/' + bdrms + '/' + limit + '/' + offset);
        },
        addressSearch: function (query) {
            return $http.get(apiEndpoint + 'AutoComplete/' + query);
        },
        // 2.0 | gets a set amount of properties t
        getResidentialProperties: function (orderBy, offset, sortByAsc, county, town, limit, baths, bathsPart, bdrms, priceMin, priceMax) {
            // map the sort boolean for sql
            sortByAsc = (sortByAsc == 'false') ? "DESC" : "ASC";
            priceMin = (priceMin == null) ? 0 : priceMin;
            priceMax = (priceMax == null) ? 9999999 : priceMax;
            county = (county == null) ? '*' : county;
            town = (!town) ? 'A' : town;
            limit = limit ? limit : 10;
            return $http.get(apiEndpoint + 'GetResidentialProperties/' + orderBy + "/" + offset + "/" + sortByAsc + "/" + county + "/" + town + "/" + limit + "/" + baths + "/" + bathsPart + "/" + bdrms + "/" + priceMin + "/" + priceMax);
        },
        // 2.0 | gets a set amount of properties
        getRentalProperties: function (orderBy, offset, sortByAsc, county, town, limit, baths, bathsPart, bdrms, priceMin, priceMax) {
            // map the sort boolean for sql
            sortByAsc = (sortByAsc == 'false') ? "DESC" : "ASC";
            priceMin = (priceMin == null) ? 0 : priceMin;
            priceMax = (priceMax == null) ? 9999999 : priceMax;
            town = (!town) ? 'A' : town;
            limit = limit ? limit : 10;
            return $http.get(apiEndpoint + 'GetRentalProperties/' + orderBy + "/" + offset + "/" + sortByAsc + "/" + county + "/" + town + "/" + limit + "/" + baths + "/" + bathsPart + "/" + bdrms + "/" + priceMin + "/" + priceMax);
        },
        getUpcomingOpenHouses : function() {
            return $http.get(apiEndpoint + 'GetUpcomingOpenHouses/');
        },
        // 2.0 | gets a set amount of properties 
        getListingTotals: function (type, county, town, baths, bathsPart, bdrms, priceMin, priceMax) {
            county = typeof county == 'undefined' ? '' : county;
            town = typeof town == 'undefined' ? '' : town;
            priceMin = (priceMin == null) ? 0 : priceMin;
            priceMax = (priceMax == null) ? 9999999 : priceMax;
            return $http.get(apiEndpoint + 'GetTotalCounts/' + type + "/" + county + "/" + town + "/" + baths + "/" + bathsPart + "/" + bdrms + "/" + priceMin + "/" + priceMax);
        },
        getGrandLiveListingTotals: function () {
            return $http.get(apiEndpoint + 'GetGrandLiveListingTotals/');
        },
        getLocation (x,y) {
            return $http.get(googleLocation + x +"," + y + "&key=" + googleApi);
        },
        getPosts () {
            return $http.get(apiEndpoint + 'GetPosts/');
        },
        getPost (slug) {
            return $http.get(apiEndpoint + 'GetPost/' + slug);
        },
        getTags () {
            return $http.get(apiEndpoint + 'GetTags/');
        },
        getCategories () {
            return $http.get(apiEndpoint + 'GetCategories/');
        },
        getCategoryById (catId) {
            return $http.get(apiEndpoint + 'GetCategoryPostsById/' + catId);
        },
        getPostsByMonth  (monthNum) {
            return $http.get(apiEndpoint + 'GetCategoryPostsByMonth/' + monthNum);
        },
        // 2.0 | gets a set amount of properties
        getListingTotalsWithinWeeks: function (type, week, county, town) {
            county = typeof county == 'undefined' ? '' : county;
            town = typeof town == 'undefined' ? '' : town;
            return $http.get(apiEndpoint + 'GetTotalCountsWithinWeeks/' + type + "/" + week + "/" + county + "/" + town);
        },
        // 2.0 | gets a set amount of properties
        getListingTotalsWithinWeeks: function (type, week, county, town) {
            county = typeof county == 'undefined' ? '' : county;
            town = typeof town == 'undefined' ? '' : town;
            return $http.get(apiEndpoint + 'GetTotalCountsWithinWeeksAny/' + type + "/" + week + "/" + town);
        },
        // 2.0 | gets a set amount of properties
        getListingTotalsWithinWeeksSold: function (type, week, county, town) {
            county = typeof county == 'undefined' ? '' : county;
            town = typeof town == 'undefined' ? '' : town;
            return $http.get(apiEndpoint + 'GetTotalCountsWithinWeeksSold/' + type + "/" + week + "/" + town);
        },
        // 2.0 | gets a set amount of properties
        getListingTotalsWithinDays: function (type, days, county, town) {
            county = typeof county == 'undefined' ? '' : county;
            town = typeof town == 'undefined' ? '' : town;
            return $http.get(apiEndpoint + 'GetTotalCountsWithinDays/' + type + "/" + days + "/" + county + "/" + town);
        },
        getAgentFunFacts(agentId) {
            return $http.get(apiEndpoint + 'GetFunFacts/' + agentId );
        },
        // 2.0 | gets recent residentials ordered by dtadded
        getRecentResidentials(amount) {
            return $http.get(apiEndpoint + 'getRecentResidentials/' + amount);
        },
        // 2.0 | gets recent rentals ordered by dtadded
        getRecentRentals(amount) {
            return $http.get(apiEndpoint + 'getRecentRentals/' + amount);
        },
        // 2.0 | gets recent residentials ordered by dtadded
        getPropertyById: function (listingId, type) {
            return $http.get(apiEndpoint + 'GetPropertyById/' + listingId + "/" + type);
        },
        // 2.0 | gets recent rentals ordered by dtadded
        getAvailableTownsByCounty(county) {
            return $http.get(apiEndpoint + 'GetAvailableTownsByCounty/' + county);
        },
        // 2.0 | search property by street name
        search: function (string) {
            return $http.get(apiEndpoint + 'Search/' + string);
        },
        // 2.0 | search property by street name
        searchPropertyByName: function (name) {
            return $http.get(apiEndpoint + 'SearchPropertyName/' + name);
        },
        // 2.0 | gets an individual property by retsId
        getGeoCodes(amount,town) {
            if (town) {
                return $http.get(apiEndpoint + 'GetGeoCodes/' + amount + '/' + town);
            }
            return $http.get(apiEndpoint + 'GetGeoCodes/' + amount);

        },
        // get properties for county
        getCountyProperties: function (county, type, offset) {
            return $http.get(phretsAPIEndpoint + 'get_properties/' + type + '/county/' + county + "/" + offset);
        },
        // get recents properties
        getRecentProperties: function (amount) {
            return $http.get(phretsAPIEndpoint + 'getMapGeoCodes/' + type + '/county/' + county + "/" + offset);
        },
        getPhotosById: function (type, listingId) {
            return $http.get(phretsAPIEndpoint + 'get_images/' + type + '/' + listingId);
        },
        geoCodeAddress: function(address) {
            var formattedAddress = address.strReplace(" ","+");
            return $http.get(googleGeoCode + 'formattedAddress&=key' + googleApiKey);
        },

    }
});