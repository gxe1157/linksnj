// the blog controller

angular.module('linksApp').controller('blogController',

    function ($scope, linksService, $sce) {
        // controller as syntax
        var vm = this;
        vm.loadPost = loadPost;
        vm.loadCategories = loadCategories;
        vm.getCategories = getCategories;
        vm.getMonths = getMonths;
        vm.loadRelated = loadRelated;
        vm.getPostsByMonth = getPostsByMonth;
        vm.loadTags = loadTags;
        vm.posts = [];
        vm.months = [];
        vm.categories = [];
        vm.selectedCategory = "All";

        vm.monthsList = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ]

        // load posts
        function loadPost() {
            vm.loading = true;
            linksService.getPost(vm.params.slug).then(function(resp) {
                vm.posts = resp.data;
                if (vm.posts.length && vm.posts[0]) {
                    vm.posts[0].created = new Date(vm.posts[0].created.replace(/\-/g,' ')).toDateString();
                }
            }, function (err) {
                console.error(err);
            }).finally(function() {
                vm.loading = false;
            })
        }
        function getMonths() {
            linksService.getMonths().then(function(resp) {
                for (var i = 0; i < resp.data.length; i++ ){
                    var m = resp.data[i].month - 1;
                    vm.months.push(vm.monthsList[m]);
                }
            }, function (err) {
                console.error(err);
            })
        }

        function loadCategories () {
            linksService.getCategories().then(function(resp) {
                vm.categories = resp.data;
            }, function (err) {
                console.error(err);
            })
        }

        function loadRelated() {
            linksService.getRecentPosts().then(function(resp) {
                vm.relatedPosts = resp.data;
            });
        }

        function getPostsByMonth(monthNum) {
            vm.selectedMonth = ' - ' + monthNum;
            vm.loading = true;
            linksService.getPostsByMonth(vm.monthsList.indexOf(monthNum)+ 1).then(function(resp) {
                vm.posts = resp.data;
                for (var i = 0; i < vm.posts.length; i++) {
                    vm.posts[i].created = new Date(vm.posts[i].created.replace(/\-/g,' ')).toDateString();
                }
            }, function (err) {
                console.error(err);
            }).finally(function(){
                vm.loading = false;
            })
        }

        function getCategories(cat, name) {
            vm.loading = true;
            vm.selectedCategory = name;
            linksService.getCategoryById(cat).then(function(resp) {
                vm.posts = resp.data;
                for (var i = 0; i < vm.posts.length; i++) {
                    vm.posts[i].created = new Date(vm.posts[i].created.replace(/\-/g,' ')).toDateString();
                }
            }, function (err) {
                console.error(err);
            }).finally(function(){
                vm.loading = false;
            })
        }

        function loadTags() {
            linksService.getTags().then(function(resp) {
                vm.tags = resp.data;
            }, function (err) {
                console.error(err);
            })
        }

        // onload / constructor
        (function () {
            vm.params = window.location.search.slice(1)
                .split('&')
                .reduce(function _reduce(/*Object*/ a, /*String*/ b) {
                    b = b.split('=');
                    a[b[0]] = decodeURIComponent(b[1]);
                    return a;
                }, {});

            vm.loadCategories();
            vm.loadPost();
            vm.getMonths();
            vm.loadTags();
            vm.loadRelated();
        })();
    });

