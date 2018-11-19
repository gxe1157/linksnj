var app = angular.module('linksApp', ['ngAnimate', 'ngSanitize', 'ui.select']);

app.config(['$locationProvider', function ($locationProvider) {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
        rewriteLinks: false
    });
}]);