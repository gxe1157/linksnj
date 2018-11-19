<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>



<!--NG Home controller -->

<script src="<?= base_url() ?>public/app/controllers/rentals.controller.js"></script>



<div ng-controller="rentalController as pc">



    <!--start section page body-->

    <section id="section-body">

        <div class="row">

            <div class="houzez-module module-title text-center estate-totals">

                <div class="container-fluid">



                    <div class="row">

                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-plus-square"></i>

                                        <h3 class="heading">

                                            <span ng-bind="pc.totalAdded"></span> - Rentals added this week

                                        </h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count rentals" data-wow-delay="0.15s">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-building"></i>

                                        <h3 class="heading">

                                            <span ng-bind="pc.totalProps"></span> - Total properties for rent

                                        </h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>



                        <div class="col-sm-12 col-sm-4 wow fadeInUp property-count sold-data" data-wow-delay="0.3s">

                            <div class="location-block">

                                <figure style="top: 50%;">

                                    <figcaption class="location-fig-caption">

                                        <i class="fas fa-dollar-sign"></i>

                                        <h3 class="heading">

                                            <span>35</span> - Properties leased this month

                                        </h3>

                                    </figcaption>

                                </figure>

                            </div>

                        </div>

                    </div>

                </div>

            </div>







            <div class="houzez-module module-title text-center">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-sm-12 col-xs-12">

                            <h2>Newest Listings</h2>

                            <h3 class="sub-heading">Check out the most recent listings on Links Residential</h3>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-lg-12 col-md-12 col-sm-12 list-grid-area container-contentbar">

                <div id="content-area">

                    <!-- No Results -->

                    <div ng-show="!props.length && !pc.loading" class="ng-hide">

                        <div class="item-wrap">

                            <div class="property-item table-list">

                                <div class="table-cell text-center no-results">

                                    <i class="fas fa-exclamation-triangle"></i>

                                    <br />

                                    No properties match the filters.

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- start Property list -->

                    <div class="ng-hide col-sm-12 col-lg-4"

                        ng-animate="'animate'"

                        ng-repeat="recent in recents = (props = pc.properties |

								orderBy :'listPrice' : sortToggle)"

                        ng-show="!sc.loading">

                        <div class="row">

                            <div class="item-wrap">

                                <div class="property-item item-grid">

                                    <div class="figure-block">

                                        <figure class="item-thumb">

                                            <div class="label-wrap hide-on-list">

                                                <div class="label-status label label-default">For Rent</div>

                                            </div>

                                            <span class="label-featured label label-success">Featured</span>

                                            <div class="price hide-on-list black-bg">

                                                <h3 ng-bind="recent.PRICECURRENT | currency"></h3>

                                            </div>

                                            <a href="/view-property?type=RNT&id={{::recent.LISTINGID}}">

                                                <img ng-src="{{recent.photos}}" onerror="this.src='<?= base_url() ?>public/images-loading.jpg'" alt="thumb" />

                                            </a>

                                            <figcaption class="thumb-caption cap-actions clearfix">

                                                <div class="pull-right">

                                                    <ul class="list-unstyled actions">

                                                        <li class="share-btn">

                                                            <div class="share_tooltip fade">

                                                                <a href="#" target="_blank">

                                                                    <i class="fa fa-facebook"></i>

                                                                </a>

                                                                <a href="#" target="_blank">

                                                                    <i class="fa fa-twitter"></i>

                                                                </a>

                                                                <a href="#" target="_blank">

                                                                    <i class="fa fa-google-plus"></i>

                                                                </a>

                                                                <a href="#" target="_blank">

                                                                    <i class="fa fa-pinterest"></i>

                                                                </a>

                                                            </div>

                                                            <span data-toggle="tooltip" data-placement="top" title="share">

                                                                <i class="fa fa-share-alt"></i>

                                                            </span>

                                                        </li>


                                                        <li>

                                                            <span data-toggle="tooltip" data-placement="top" title="Photos (12)">

                                                                <i class="fa fa-camera"></i>

                                                            </span>

                                                        </li>

                                                    </ul>

                                                </div>

                                            </figcaption>

                                        </figure>

                                    </div>

                                    <div class="item-body">



                                        <div class="body-left">

                                            <div class="info-row">

                                                <h2 class="property-title">

                                                    <a href="/view-property?type=RNT&id={{::recent.LISTINGID}}">

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

                                                        <a href="/view-property?type=RNT&id={{::recent.LISTINGID}}" class="btn btn-primary">

                                                            Details

                                                            <i class="fas fa-info-circle"></i>

                                                        </a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>







        <!--start location module-->

        <div class="houzez-module-main module-white-bg">

            <div class="houzez-module module-title text-center">

                <div class="container-fluid">

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

                                        <img src="<?= base_url() ?>public/images/counties/RidgewoodDowntown.jpg" alt="Image" />

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

                                        <img src="<?= base_url() ?>public/images/counties/hudson.jpg" alt="Image" />

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

                                        <img src="<?= base_url() ?>public/images/counties/essex.jpg" alt="Image" />

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

                                        <img src="<?= base_url() ?>public/images/counties/morris.jpg" alt="Image" />

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

                                        <img src="<?= base_url() ?>public/images/counties/pat.jpg" alt="Image" />

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

                                        <img src="<?= base_url() ?>public/images/counties/union.jpg" alt="Image" />

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





    </section>

    <!--end section page body-->

</div>