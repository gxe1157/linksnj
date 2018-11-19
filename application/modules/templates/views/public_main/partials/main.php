<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>



<!--NG Home controller -->

<script src="<?= base_url() ?>public/app/controllers/home.controller.js?v=123"></script>



<div ng-controller="homepageController as hc" class="homepage">

<!-- Banner Start -->

<?php $this->load->view('html_head_slider'); ?>



<!-- Banner End -->

    <!--start section page body-->

    <section id="section-body">

        <div class="houzez-module-main">

            <!-- welcome -->

            <div class="container welcome-message">

                <div class="row">

                    <div class="small-11 large-7 columns small-centered padding-small">

                        <h2 class="text-center">We are thrilled to introduce you to Links Residential Real Estate!</h2>

                        <div class="text-center lh-group">

                            <div class="text-bigger">

                                We are a progressive, out-of-the-box thinking real estate agency committed to providing our clients with the highest level of real estate services in New Jersey!

                            </div>

                            <br>

                            <div class="wow fadeInUp">

                                <a href="<?= base_url() ?>about-us" target="_self" class="btn-primary btn-lg">Learn more about Links Residential</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="container-fluid extra-homepage-content">

                <div class="row">

                    <div class="col-sm-3 text-center">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/b9oHDUAM0rM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    </div>



                    <div class="col-sm-3 text-center">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/D9chhGJJMHo" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    </div>



                    <div class="col-sm-3 text-center">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/EsoZmWGpTsU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    </div>

                    <div class="col-sm-3 text-center">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/IQyVTjFXn5E" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                    </div>

                </div>

            </div>






        <div class="houzez-module-main ng-hide" ng-show="!vm.recentTownListingsLoading && hc.recentTownListings.length">

            <div class="houzez-module module-title text-center">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-12">

                            <h2>Links Featured Properties <span ng-bind="' near - ' + hc.currentTown"></span></h2>

                            <h3 class="sub-heading">Links Residential near you.</h3>

                        </div>

                    </div>

                </div>

            </div>

            <div id="property-item-module" class="houzez-module property-item-module">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="row grid-row">



                                <!-- loading -->

                                <div class="loader" ng-show="hc.recentLoading">Loading...</div>



                                <!-- Loop over results -->

                                <div class="col-sm-12 col-lg-3 ng-hide" ng-repeat="recent in hc.recentTownListings" ng-show="!hc.recentTownListingsLoading">

                                    <div class="item-wrap">

                                        <div class="property-item item-grid">

                                            <div class="figure-block">

                                                <figure class="item-thumb">

                                                    <div class="label-wrap hide-on-list">

                                                        <div class="label-status label label-default" ng-bind="::recent.PROPTYPE == '1' ? 'For Sale' : 'For Rent'"></div>

                                                    </div>

                                                    <span class="label-featured label label-success">Featured</span>

                                                    <div class="price hide-on-list black-bg">

                                                        <h3 ng-bind="recent.PRICECURRENT | currency"></h3>

                                                    </div>

                                                    <a ng-href="{{::recent.PROPTYPE == '1' ? '/view-property?type=RES&id=' + recent.LISTINGID : '/view-property?type=RNT&id=' + recent.LISTINGID}}">

                                                        <img ng-src="{{recent.photos}}" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" alt="thumb">

                                                    </a>

                                                    <figcaption class="thumb-caption cap-actions clearfix">



                                                    </figcaption>

                                                </figure>

                                            </div>

                                            <div class="item-body">



                                                <div class="body-left">

                                                    <div class="info-row">

                                                        <h2 class="property-title">

                                                            <a href="#">

                                                                <span ng-bind="recent.STREETNUM"></span>

                                                                <span ng-bind="recent.STREET"></span>

                                                                <span ng-bind="recent.STREETTYP"></span>,

                                                                <span ng-bind="recent.AREANAME"></span>

                                                            </a>

                                                        </h2>

                                                    </div>

                                                    <div class="table-list full-width info-row">

                                                        <div class="cell">

                                                            <div class="info-row amenities">

                                                                <p>

                                                                    <span ng-bind="'Rooms: ' + recent.NUMROOMS"></span>

                                                                    <span ng-bind="'Beds: ' + recent.BDRMS"></span>

                                                                    <span ng-bind="'Baths: ' + recent.BATHSFULL"></span>

                                                                </p>

                                                                <p ng-bind="'Type: ' + recent.SUBSTYLE"></p>

                                                            </div>

                                                        </div>

                                                        <div class="cell">

                                                            <div class="phone">

                                                                <a href="/view-property?type=RES&id={{::recent.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>

                                                                <p><a href="#">+1 (786) 225-0199</a></p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>



                                            </div>

                                        </div>

                                        <div class="item-foot date hide-on-list">

                                            <div class="item-foot-left">

                                                <p><i class="fa fa-user"></i> <a href="#">Links Residential</a></p>

                                            </div>

                                            <div class="item-foot-right">


                                            </div>

                                        </div>

                                    </div>

                                </div>





                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!--end property item module-->


        </div>

        <!--end carousel module-->


        <!--start property item module-->

                <div class="houzez-module-main module-gray-bg">

                    <div class="houzez-module module-title text-center">

                        <div class="container">

                            <div class="row">

                                <div class="col-sm-12">

                                    <h2>Links Featured Properties <span ng-bind="' near - ' + hc.currentCounty + ' county'"></span></h2>

                                    <h3 class="sub-heading">Links Residential offers the best properties.</h3>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div id="property-item-module" class="houzez-module property-item-module">

                        <div class="container-fluid">

                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="row grid-row">



                                        <!-- loading -->

                                        <div class="loader" ng-show="hc.recentLoading">Loading...</div>



                                        <!-- Loop over results -->

                                        <div class="col-sm-12 col-lg-3 ng-hide" ng-repeat="recent in hc.recent" ng-show="!hc.recentLoading">

                                            <div class="item-wrap">

                                                <div class="property-item item-grid">

                                                    <div class="figure-block">

                                                        <figure class="item-thumb">

                                                            <div class="label-wrap hide-on-list">

                                                                <div class="label-status label label-default">For Sale</div>

                                                            </div>

                                                            <span class="label-featured label label-success">Featured</span>

                                                            <div class="price hide-on-list black-bg">

                                                                <h3 ng-bind="recent.PRICECURRENT | currency"></h3>

                                                            </div>

                                                            <a href="/view-property?type=RES&id={{::recent.LISTINGID}}">

                                                                <img ng-src="{{recent.photos}}" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" alt="thumb">

                                                            </a>

                                                            <figcaption class="thumb-caption cap-actions clearfix">


                                                            </figcaption>

                                                        </figure>

                                                    </div>

                                                    <div class="item-body">



                                                        <div class="body-left">

                                                            <div class="info-row">

                                                                <h2 class="property-title">

                                                                    <a href="#">

                                                                        <span ng-bind="recent.STREETNUM"></span>

                                                                        <span ng-bind="recent.STREET"></span>

                                                                        <span ng-bind="recent.STREETTYP"></span>,

                                                                        <span ng-bind="recent.AREANAME"></span>

                                                                    </a>

                                                                </h2>

                                                            </div>

                                                            <div class="table-list full-width info-row">

                                                                <div class="cell">

                                                                    <div class="info-row amenities">

                                                                        <p>

                                                                            <span ng-bind="'Rooms: ' + recent.NUMROOMS"></span>

                                                                            <span ng-bind="'Beds: ' + recent.BDRMS"></span>

                                                                            <span ng-bind="'Baths: ' + recent.BATHSFULL"></span>

                                                                        </p>

                                                                        <p ng-bind="'Type: ' + recent.SUBSTYLE"></p>

                                                                    </div>

                                                                </div>

                                                                <div class="cell">

                                                                    <div class="phone">

                                                                        <a href="/view-property?type=RES&id={{::recent.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>

                                                                        <p><a href="#">+1 (786) 225-0199</a></p>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>



                                                    </div>

                                                </div>

                                                <div class="item-foot date hide-on-list">

                                                    <div class="item-foot-left">

                                                        <p><i class="fa fa-user"></i> <a href="#">Links Residential</a></p>

                                                    </div>

                                                    <div class="item-foot-right">


                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!--end property item module-->


        <!--start location module-->

        <div class="houzez-module-main module-white-bg">

            <div class="houzez-module module-title text-center">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-12 col-xs-12">

                            <h2>Our Locations</h2>

                            <h3 class="sub-heading">New Jersey properties in amazing locations.</h3>

                        </div>

                    </div>

                </div>

            </div>

            <div id="location-modul" class="houzez-module location-module grid">

                <div class="container">

                    <div class="row">

                        <div class="col-sm-4 wow fadeInUp">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=BERGEN">

                                        <img src="<?= base_url() ?>public/images/counties/RidgewoodDowntown.jpg" alt="Image">

                                    </a>

                                    <figcaption class="location-fig-caption">

                                        <h3 class="heading">Bergen</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.15s">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=HUDSON">

                                        <img src="<?= base_url() ?>public/images/counties/hudson.jpg" alt="Image">

                                    </a>

                                    <div class="location-fig-caption">

                                        <h3 class="heading">Hudson</h3>

                                    </div>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.3s">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=ESSEX">

                                        <img src="<?= base_url() ?>public/images/counties/essex.jpg" alt="Image">

                                    </a>

                                    <figcaption class="location-fig-caption">

                                        <h3 class="heading">Essex</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>



                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.45s">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=MORRIS">

                                        <img src="<?= base_url() ?>public/images/counties/morris.jpg" alt="Image">

                                    </a>

                                    <figcaption class="location-fig-caption">

                                        <h3 class="heading">Morris</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-4 wow fadeInUp" data-wow-delay=".60s">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=PASSAIC">

                                        <img src="<?= base_url() ?>public/images/counties/pat.jpg" alt="Image">

                                    </a>

                                    <div class="location-fig-caption">

                                        <h3 class="heading">Passaic</h3>

                                    </div>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-4 wow fadeInUp" data-wow-delay=".75s">

                            <div class="location-block">

                                <figure>

                                    <a href="<?= base_url() ?>county?county=UNION">

                                        <img src="<?= base_url() ?>public/images/counties/union.jpg" alt="Image">

                                    </a>

                                    <figcaption class="location-fig-caption">

                                        <h3 class="heading">Union</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

        <!--end location module-->

        <!--start location module-->

        <div class="houzez-module-main module-white-bg">

            <div id="location-modul" class="houzez-module location-module grid totals estate-totals">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-home"></i>

                                        <h3 class="heading"><span ng-bind="hc.buyAmounts"></span> - Total Properties for sale</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count rentals" data-wow-delay="0.15s">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-building"></i>

                                        <h3 class="heading"><span ng-bind="hc.rentAmounts"></span> - Total Properties for rent</h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count  sold-data" data-wow-delay="0.3s">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-plus-square"></i>

                                        <h3 class="heading">

                                            <span ng-bind="hc.soldTotals"></span> - Properties sold this month

                                        </h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!--end location module-->



    </section>

    <!--end section page body-->

</div>