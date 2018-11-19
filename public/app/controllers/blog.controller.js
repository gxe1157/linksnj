// the blog controller
angular.module('linksApp').controller('blogController',

    function ($scope, linksService) {
        // controller as syntax
        var vm = this;
        vm.loadPosts = loadPosts;
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
        function loadPosts() {
            vm.loading = true;
            linksService.getPosts().then(function(resp) {
                vm.posts = resp.data;
                for (var i = 0; i < vm.posts.length; i++) {
                    vm.posts[i].created = new Date(vm.posts[i].created.replace(/\-/g,' ')).toDateString();
                }
                trimBlogs();
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
                trimBlogs();
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
                trimBlogs();
            }, function (err) {
                console.error(err);
            }).finally(function(){
                vm.loading = false;
            })
        }

        function trimBlogs () {
            for(var i = 0; i < vm.posts.length; i++) {
                if(vm.posts[i].body.length >= 3200) {
                    vm.posts[i].readMore = true;
                    vm.posts[i].body = vm.posts[i].body.substring(0,3200);
                }
            }
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
            vm.loadCategories();
            vm.loadPosts();
            vm.loadTags();
            vm.getMonths();
            vm.loadRelated();
        })();
    });

