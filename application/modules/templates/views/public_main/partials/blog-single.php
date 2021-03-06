<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!--start section page body-->

    <script src="<?= base_url() ?>public/app/controllers/single-blog.controller.js"></script>


    <section id="section-body" ng-controller="blogController as bc">

        <!--start detail content-->

        <section class="section-detail-content blog-page">

            <div class="loader" ng-show="bc.loading">Loading...</div>

            <div class="container" ng-show="!bc.loading">

                <div class="row">

                    <div class="col-lg-8 col-md-8 col-sm-12 container-contentbar">
                        <h4>Current Category: <span ng-bind="bc.selectedCategory"></span><span ng-bind="bc.selectedMonth"></span></h4>
                        <div class="article-main" ng-repeat="post in bc.posts">
                            <h1 ng-bind="::post.title"></h1>
                            <h4 ng-bind="::post.created"></h4>

                            <img ng-src="{{post.featured_image}}" />

                            <iframe style="margin:10px 0" ng-if="post.youtubecode " width="100%" height="315" ng-src="{{ post.youtubecode  | trustUrl }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            <p ng-bind-html="::post.body  | toTrusted"></p>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-0 col-sm-offset-3 container-sidebar">

                    <aside id="sidebar" class="sidebar-white">

                        <div>
                            <h2 style="text-align:center;">Tags</h2>
                            <ul class="list-unstyled blog-tags">
                                <li ng-repeat="tag in bc.tags">
                                    <a ng-bind="'#' + tag.name" class="btn-primary btn"></a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h2 style="text-align:center;">Post Archives</h2>
                            <ul class="list-unstyled">
                                <li><a href="#" ng-click="bc.loadPosts()"><span style="color:grey">(View All)</span></li>
                                <li ng-repeat="month in bc.months">
                                    <a class="cp" ng-bind="month" ng-click="bc.getPostsByMonth(month)"></a>
                                </li>
                            </ul>
                        </div>

                        <div>
                        <h2 style="text-align:center;">Blog Categories</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" ng-click="bc.loadPosts()"><span style="color:grey">(View All)</span></li>
                            <li ng-repeat="category in bc.categories">
                                <a class="cp" href="#" ng-bind="category.name" ng-click="bc.getCategories(category.id, category.name)"></a>
                            </li>
                        </ul>
                        </div>

                        <div>
                           <h2 style="text-align:center;">Recent Posts</h2>
                            <ul class="list-unstyled" ng-show="bc.relatedPosts">
                                <li ng-repeat="related in bc.relatedPosts">
                                    <a href="blog-single.php?slug={{related.slug}}" ng-bind="::related.title"></a>
                                </li>
                            </ul>
                        </div>

                        <?php $this->load->view('aside/side-bar'); ?>

                    </aside>

                    </div>

                </div>

            </div>

        </section>

        <!--end detail content-->

    </section>

    <!--end section page body-->
