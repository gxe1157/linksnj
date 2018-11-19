<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--NG Home controller -->
<script src="<?= base_url() ?>public/app/controllers/bergen.controller.js"></script>

    <!--start section page body-->
    <section id="section-body" ng-controller="propertiesController as pc">
        <div class="container">
            <div class="page-title breadcrumb-top">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb"><li ><a href="/"><i class="fa fa-home"></i></a></li><li class="active">Links Listing – List View</li></ol>
                        <div class="page-title-left">
                            <h2 ng-bind="pc.county + ' County ' + pc.total + ' Total Results Found'"></h2>
                        </div>
                        <div class="page-title-right">
							<!-- toggle -->
                            <div class="view hidden-xs">
                                <div class="table-cell">
                                    <span class="view-btn btn-list active"><i class="fa fa-th-list"></i></span>
                                    <span class="view-btn btn-grid"><i class="fa fa-th-large"></i></span>
                                </div>
                            </div>

                            <!-- FILTERS -->
                            <div style="float:right; margin-right: 10px; margin-top: 7px;">
                                <select ng-model="sortModel" ng-change="pc.changeSort(sortModel)" ng-init="sortModel = 'DTADD,false'">

                                    <option value="DTADD,false">Date added high to low</option>
                                    <option value="DTADD,true">Date added low to high</option>

                                    <option default value="PRICECURRENT,false">Price high to low</option>
                                    <option value="PRICECURRENT,true">Price low to high</option>

                                    <option value="BDRMS,false">Bedrooms high to low</option>
                                    <option value="BDRMS,true,sortAsc:true}">Bedrooms low to high</option>

                                    <option value="BATHSFULL,false">Bathrooms high to low</option>
                                    <option value="BATHSFULL,true,sortAsc:true}">Bathrooms low to high</option>

                                </select>

                                <!-- Town Filter -->
                                <select ng-model="pc.selectedTown" ng-options="town for town in pc.availableTowns" ng-change="pc.loadProperties()"></select>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 list-grid-area container-contentbar">
                    <div id="content-area">
                        <!--start list tabs-->
                        <div class="list-tabs table-list full-width">
                            <div class="tabs table-cell">
                                <ul>
                                    <li>
                                        <a ng-class="{active : pc.type === 'RES'}" ng-click="pc.type = 'RES'; pc.loadProperties(); ">FOR SALE</a>
                                    </li>
                                    <li>
                                        <a ng-class="{active : pc.type === 'RNT'}" ng-click="pc.type = 'RNT'; pc.loadRentals();">FOR RENT</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--end list tabs-->

						<!-- No Results -->
						<div ng-show="!props.length && !pc.loading" class="ng-hide">
							<div class="item-wrap">
                                <div class="property-item table-list">
                                    <div class="table-cell text-center no-results">
										<i class="fas fa-exclamation-triangle"></i><br>
										No properties match the filters.
									</div>
								</div>
							</div>
						</div>

                        <!-- start Pagination -->
                        <div class="pagination-main ng-hide" ng-show="!sc.loading">
                            <ul class="pagination">
                                <li><a aria-label="Previous" ng-disabled="pc.offset <= 0" ng-click="!pc.offset <= 0;pc.paginate(-pc.offIncrement)"><i class="fa fa-angle-left"></i></span></a></li>
                                <li><a aria-label="Next" ng-click="pc.paginate(pc.offIncrement)"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
                            </ul>
                        </div>

                        <!-- start Property list -->
                        <div class="property-listing list-view ng-hide" 
                             ng-animate="'animate'" 
							 ng-repeat="property in props = (props = pc.properties | 
								orderBy :'listPrice' : sortToggle)" ng-show="!sc.loading">
                            <div class="row">
                                <div class="item-wrap">
                                    <div class="property-item table-list">
                                        <div class="table-cell">
                                            <div class="figure-block">
                                                <figure class="item-thumb">
                                                    <span class="label-featured label label-success">Featured </span>
                                                    <div class="price hide-on-list">
                                                        <h3 ng-bind="property.readableListPrice | currency"></h3>
                                                    </div>
                                                    
                                                    <a href="/view-property?type={{::pc.type}}&id={{::property.LISTINGID}}">
                                                        <img ng-src="{{property.photos}}" alt="thumb">
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
                                        <div class="item-body table-cell">

                                            <div class="body-left table-cell">
                                                <div class="info-row">
                                                    <h2 class="property-title"><a href="/view-property?type={{::pc.type}}&id={{::property.LISTINGID}}"><span ng-bind="property.AREANAME"></span></a></h2>
                                                    <p>
														<span ng-bind="property.STREETNUM"></span>
														<span ng-bind="property.STREET"></span>
														<span ng-bind="property.STREETTYP"></span> 
														 
													</p>
                                                    </h4>
                                                </div>
                                                <div class="info-row amenities hide-on-grid">
                                                    <p>
                                                        <span ng-bind="'Rooms: ' + property.NUMROOMS"></span>
                                                        <span ng-bind="'Beds: ' + property.BDRMS"></span>
                                                        <span ng-bind="'Baths: ' + property.BATHSFULL"></span>
                                                    </p>
													<br>
                                                    <p ng-bind="'Type: ' + property.SUBSTYLE"></p>
                                                </div>
                                                <div class="info-row date hide-on-grid">
                                                    <p><i class="fa fa-user"></i> <a href="<?= base_url() ?>property/<?= $mlsId ?>" ng-bind="property.LOFFNAME"></a></p>
                                                    <p><i class="fa fa-calendar"></i> <span ng-bind="property.DTADD"></span> </p>
                                                </div>
                                            </div>
                                            <div class="body-right table-cell hidden-gird-cell">
                                                <div class="info-row price">
                                                    <h3 ng-bind="property.PRICECURRENT | currency"></h3>
                                                    <p class="rant" ng-bind="property.YEARBUILT">$0/mo</p>
                                                </div>
                                                <div class="info-row phone text-right">
                                                    <a href="/view-property?type={{pc.type}}&id={{::property.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>
                                                    <p><a href="<?= base_url() ?>property/<?= $mlsId ?>">+1 (786) 225-0199</a></p>
                                                </div>
                                            </div>
                                            <div class="table-list full-width hide-on-list">
                                                <div class="cell">
                                                    <div class="info-row amenities">
                                                        <p>
                                                            <span ng-bind="'Beds: ' + property.property_bedrooms"></span>
                                                            <span ng-bind="'Baths: ' + property.property_bathsFull"></span>
                                                            <span ng-bind="'Dimensions: ' + property.property_lotSize"></span>
                                                        </p>
                                                        <p ng-bind="property.property_style"></p>
                                                    </div>
                                                </div>
                                                <div class="cell">
                                                    <div class="phone">
                                                        <a href="<?= base_url() ?>property/<?= $mlsId ?>" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
                                                        <p><a href="<?= base_url() ?>property/<?= $mlsId ?>">+1 (786) 225-0199</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-foot date hide-on-list">
                                        <div class="item-foot-left">
                                            <p><i class="fa fa-user"></i> <a href="<?= base_url() ?>property/<?= $mlsId ?>">Links Residential</a></p>
                                        </div>
                                        <div class="item-foot-right">
                                            <p><i class="fa fa-calendar"></i> 12 Days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 
                        <!--end property items-->
						<hr />
                        <!-- loading -->
                        <div class="loader" ng-show="pc.loading">Loading...</div>

                        <!--start Pagination-->
                        <div class="pagination-main ng-hide" ng-show="!sc.loading">
                            <ul class="pagination">
                                <li><a aria-label="Previous" ng-disabled="pc.offset <= 0" ng-click="!pc.offset <= 0; pc.paginate(-pc.offIncrement)"><i class="fa fa-angle-left"></i></span></a></li>
                                <li><a aria-label="Next" ng-click="pc.paginate(pc.offIncrement)"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
                            </ul>
                        </div>
                        <!--start Pagination-->

                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-md-offset-0 col-sm-offset-3 container-sidebar">
                    <aside id="sidebar" class="sidebar-white">
                        <?php $this->load->view('html_head_slider'); ?>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--end section page body-->
