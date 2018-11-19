angular.module('linksApp').filter('toTrusted', function ($sce) {
    return function (value) {
        return $sce.trustAsHtml(value);
    };
});

angular.module('linksApp').filter('trustUrl', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
});