<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>



<!--NG Home controller -->

<script src="<?= base_url() ?>public/app/controllers/town.controller.js"></script>



    <!--start section page body-->

    <section id="section-body" ng-controller="townController as pc">

        <div class="container-fluid">

            <div class="page-title breadcrumb-top">

                <div class="row">

                    <div class="col-sm-12">

                        <ol class="breadcrumb"><li ><a href="/"><i class="fa fa-home"></i></a></li><li class="active">Links Listing – List View</li></ol>

                        <div class="page-title-left">


                            <span ng-show="!pc.countLoading" class="ng-hide property-title" ng-bind="pc.totalProps + ' listings found'"></span>

                        </div>

                    </div>

                    <!-- FILTERS -->

                    <div style="float:right; margin-right: 10px; margin-top: 7px;">

                        <select ng-model="pc.bedrooms" ng-change="pc.loadProperties()">
                            <option value="A">Any Bedrooms</option>
                            <option value="1">1 Bedrooms</option>
                            <option value="2">2 Bedrooms</option>
                            <option value="3">3 Bedrooms</option>
                            <option value="4">4 Bedrooms</option>
                            <option value="5">5 Bedrooms</option>
                        </select>


                        <select ng-model="pc.baths" ng-change="pc.loadProperties()">
                            <option value="A">Any Baths</option>
                            <option value="1">1 Baths</option>
                            <option value="2">2 Baths</option>
                            <option value="3">3 Baths</option>
                            <option value="4">4 Baths</option>
                            <option value="5">5 Baths</option>
                        </select>

                         <input style="width:100px; line-height: 17px;" ng-model="pc.priceMin" ng-model-options="{ debounce: 500 }" placeholder="price low" ng-change="pc.loadProperties()"></input>
                         <input style="width:100px; line-height: 17px;" ng-model="pc.priceMax" ng-model-options="{ debounce: 500 }" placeholder="price high" ng-change="pc.loadProperties()"></input>

                    </div>

                </div>

            </div>


            <div class="header-media">
                <div class="page-banner-image banner-single-item">
                    <div class="banner-inner banner-page-title banner-parallax mb-16" style="background-image: url(<?= base_url() ?>/public/images/sketch.jpg);">
                        <div class="banner-caption">
                            <h1 ng-bind="pc.selectedTown"></h1>
                            <h2 ng-bind="pc.county + ' County'"></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="houzez-module-main module-gray-bg">
                <div class="row">
                </div>
            </div>

            <div class="row">

            <div class="col-sm-12 container-sidebar">

                                <aside id="sidebar" class="sidebar-white">

                                    <style>
                                    #map {
                                        height: 400px;
                                    }
                                    </style>

                                    <div class="col-sm-12 col-xs-12 module-title text-center">

                                        <h2>On the map:</h2>

                                        <h3 class="sub-heading">Check out the most recent listings on Links Residential</h3>

                                    </div>

                                    <?php $this->load->view('html_head_slider'); ?>

                                </aside>

                            </div>

                <div class="col-sm-12 list-grid-area container-contentbar">

                    <div id="content-area">

                        <!--start list tabs-->

                        <div class="list-tabs table-list full-width">

                            <div class="tabs table-cell">

                                <ul>

                                    <li>

                                        <a ng-class="{active : pc.type === 'RES'}" ng-click="pc.buyRent = 'res'; pc.type = 'res'; pc.resetPagination(); pc.loadProperties(); ">FOR SALE</a>

                                    </li>

                                    <li>

                                        <a ng-class="{active : pc.type === 'RNT'}" ng-click="pc.buyRent = 'rnt'; pc.type = 'rnt'; pc.resetPagination(); pc.loadRentals();">FOR RENT</a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!--end list tabs-->



						<!-- No Results -->

						<div ng-show="!props.length && !pc.loading" class="ng-hide">

							<div>

                                <div class="property-item table-list">

                                    <div class="table-cell text-center no-results">

										<i class="fas fa-exclamation-triangle"></i><br>

										No properties match the filters.

									</div>

								</div>

							</div>

						</div>



                        <!-- start Property list -->

                        <div class="col-sm-12 col-lg-4 ng-scope ng-hide"

                             ng-animate="'animate'"

							 ng-repeat="property in props = (props = pc.properties |

								orderBy :'listPrice' : sortToggle)" ng-show="!pc.loading">

                            <div class="row">

                                <div class="item-wrap">

                                    <div class="property-item item-grid">

                                        <div class="table-cell">

                                            <div class="figure-block">

                                                <figure class="item-thumb">

                                                    <span class="label-featured label label-success">Featured </span>

                                                    <div class="price hide-on-list black-bg">

                                                        <h3 ng-bind="property.PRICECURRENT | currency"></h3>

                                                    </div>



                                                    <a href="<?= base_url() ?>view-property?type={{::pc.type}}&id={{::property.LISTINGID}}">

                                                        <img ng-src="{{property.photos}}" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" alt="thumb">

                                                    </a>



                                                    <figcaption class="thumb-caption cap-actions clearfix">

                                                        <ul class="list-unstyled actions pull-right">

                                                            <li>

                                                                <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Favorite">

                                                                    <i class="fa fa-heart"></i>

                                                                </span>

                                                            </li>

                                                            <li class="share-btn">

                                                                <div class="share_tooltip fade">

                                                                    <a target="_blank" href="<?= base_url() ?>properties"><i class="fa fa-facebook"></i></a>

                                                                    <a target="_blank" href="<?= base_url() ?>properties"><i class="fa fa-twitter"></i></a>

                                                                    <a target="_blank" href="<?= base_url() ?>properties"><i class="fa fa-google-plus"></i></a>

                                                                    <a target="_blank" href="<?= base_url() ?>properties"><i class="fa fa-pinterest"></i></a>

                                                                </div>

                                                                <span title="" data-placement="top" data-toggle="tooltip" data-original-title="share"><i class="fa fa-share-alt"></i></span>

                                                            </li>

                                                            <li>

                                                                <span data-toggle="tooltip" data-placement="top" title="Photos (12)">

                                                                    <i class="fa fa-camera"></i> <!--<span class="count">(12)</span>-->

                                                                </span>

                                                            </li>

                                                        </ul>

                                                    </figcaption>

                                                </figure>

                                            </div>

                                        </div>

                                        <div class="item-body">


                                                <div class="body-left">

                                                    <div class="info-row">

                                                        <h2 class="property-title">

                                                            <a href="#">

                                                                <span ng-bind="property.STREETNUM"></span>

                                                                <span ng-bind="property.STREET"></span>

                                                                <span ng-bind="property.STREETTYP"></span>,

                                                                <span ng-bind="property.AREANAME"></span>

                                                            </a>

                                                        </h2>

                                                    </div>

                                                    <div class="table-list full-width info-row">

                                                        <div class="cell">

                                                            <div class="info-row amenities">

                                                                <p>

                                                                    <span ng-bind="'Beds: ' + property.BDRMS"></span>
                                                                    <span ng-bind="'Baths: ' + property.BATHSFULL"></span>
                                                                    <span ng-bind="'Baths Part: ' + property.BATHSPART"></span>

                                                                </p>

                                                                <p ng-bind="'Type: ' + property.STYLE"></p>

                                                            </div>

                                                        </div>

                                                        <div class="cell">

                                                            <div class="phone">

                                                                <a href="<?= base_url() ?>view-property?type=RES&id={{::property.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>

                                                                <p><a href="#">+1 (786) 225-0199</a></p>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>



                                        </div>

                                    </div>

                                    <div class="item-foot date hide-on-list">

                                        <div class="item-foot-left">

                                            <p><i class="fa fa-user"></i> <a href="<?= base_url() ?>property/<?= $mlsId ?>">Links Residential</a></p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!--end property items-->

						<hr />

                        <!-- loading -->

                        <div class="loader" ng-show="pc.loading">Loading...</div>



                        <!-- start Pagination -->

                        <div class="pagination-main ng-hide" ng-show="!pc.loading && props.length">

                            <ul class="pagination">

                                <li><a aria-label="Previous" ng-disabled="pc.currentPage <= 1" ng-click="(pc.currentPage <= 1) || pc.paginate(-pc.offIncrement, -1)"><i class="fa fa-angle-left"></i></span></a></li>

                                <li class="paginator-text"><p>Viewing page <strong ng-bind="pc.currentPage"></strong> of <strong ng-bind="pc.totalPages"></strong> pages</p></li>

                                <li><a aria-label="Next" ng-disabled="pc.currentPage == pc.totalPages" ng-click="(pc.currentPage == pc.totalPages) || pc.paginate(pc.offIncrement, 1)"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>

                            </ul>

                        </div>



                    </div>

                </div>


            </div>

        </div>

    </section>

    <!--end section page body-->



