<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--NG Home controller -->
<script src="<?= base_url() ?>public/app/controllers/properties.controller.js"></script>

    <!--start section page body-->
    <section id="section-body" ng-controller="propertiesController as pc">
        <div class="container">
            <div class="page-title breadcrumb-top">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb"><li ><a href="/"><i class="fa fa-home"></i></a></li><li class="active">Links Listing – List View</li></ol>
                        <div class="page-title-left">
                            <h2>Links Listing – List View</h2>
                        </div>
                        <div class="page-title-right">
                            <div class="view hidden-xs">
                                <div class="table-cell">
                                    <span class="view-btn btn-list active"><i class="fa fa-th-list"></i></span>
                                    <span class="view-btn btn-grid"><i class="fa fa-th-large"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 list-grid-area container-contentbar">
                    <div id="content-area">
                        <!--start list tabs-->
                        <div class="list-tabs table-list full-width">
                            <div class="tabs table-cell">
                                <ul>
                                    <li>
                                        <a ng-class="{active : pc.searchObj.rentalInput == '!!'}" ng-click="pc.searchObj.rentalInput = '!!'">ALL</a>
                                    </li>
                                    <li>
                                        <a ng-class="{active : !pc.searchObj.rentalInput}" ng-click="pc.searchObj.rentalInput = false">FOR SALE</a>
                                    </li>
                                    <li>
                                        <a ng-class="{active : pc.searchObj.rentalInput === true}" ng-click="pc.searchObj.rentalInput = true">FOR RENT</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sort-tab table-cell text-right">
                                Sort by:

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

                        <div class="property-listing list-view ng-hide" 
                             ng-animate="'animate'" ng-repeat="property in props = (props = pc.properties | 
							filter: searchInput | 
							filter: {'property_bedrooms' : bedroomAmount} |
							filter : {isRental : pc.searchObj.rentalInput} | 
                        orderBy :'listPrice' : sortToggle)" ng-show="!sc.loading">
                            <div class="row">
                                <div class="item-wrap">
                                    <div class="property-item table-list">
                                        <div class="table-cell">
                                            <div class="figure-block">
                                                <figure class="item-thumb">
                                                    <span class="label-featured label label-success">Featured </span>
                                                    <div class="price hide-on-list">
                                                        <h3 ng-bind="property.readableListPrice"></h3>
                                                        <p class="rant">$21,000/mo</p>
                                                    </div>
                                                    
                                                    <a href="#">
                                                        <img ng-src="{{property.photos[0]}}" alt="thumb">
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
                                                    <div class="rating">
                                                        <span data-title="Average Rate: 4.67 / 5" class="bottom-ratings tip"><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span style="width: 93.4%" class="top-ratings"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></span>
                                                        </span>
                                                        <span class="star-text-right">15 Ratings</span>
                                                    </div>
                                                    <h2 class="property-title"><a href="<?= base_url() ?>property/<?= $mlsId ?>">Listing #: <span ng-bind="property.listingId"></span></a></h2>
                                                    <h4 class="property-location" ng-bind="property.address_full">
                                                    </h4>
                                                </div>
                                                <div class="info-row amenities hide-on-grid">
                                                    <p>
                                                        <span ng-bind="'Beds: ' + property.property_bedrooms"></span>
                                                        <span ng-bind="'Baths: ' + property.property_bathsFull"></span>
                                                        <span ng-bind="'Dimensions: ' + property.property_lotSize"></span>
                                                    </p>
                                                    <p ng-bind="property.property_style"></p>
                                                </div>
                                                <div class="info-row date hide-on-grid">
                                                    <p><i class="fa fa-user"></i> <a href="<?= base_url() ?>property/<?= $mlsId ?>">Links Residential</a></p>
                                                    <p><i class="fa fa-calendar"></i> <span ng-bind="property.modified"></span> </p>
                                                </div>
                                            </div>
                                            <div class="body-right table-cell hidden-gird-cell">
                                                <div class="info-row price">
                                                    <h3 ng-bind="property.readableListPrice"></h3>
                                                    <p class="rant">$21,000/mo</p>
                                                </div>
                                                <div class="info-row phone text-right">
                                                    <a href="<?= base_url() ?>property/<?= $mlsId ?>" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
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
<?php//} ?>                        
                        <!--end property items-->
<hr />
                        <!-- loading -->
                        <div class="loader" ng-show="sc.loading">Loading...</div>

                        <!--start Pagination-->
                        <div class="pagination-main">
                            <ul class="pagination">
                                <li class="disabled"><a aria-label="Previous" href="<?= base_url() ?>properties"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>
                                <li class="active"><a href="<?= base_url() ?>properties">1 <span class="sr-only">(current)</span></a></li>
                                <li><a href="<?= base_url() ?>properties">2</a></li>
                                <li><a href="<?= base_url() ?>properties">3</a></li>
                                <li><a href="<?= base_url() ?>properties">4</a></li>
                                <li><a href="<?= base_url() ?>properties">5</a></li>
                                <li><a aria-label="Next" href="<?= base_url() ?>properties"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
                            </ul>
                        </div>
                        <!--start Pagination-->

                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-0 col-sm-offset-3 container-sidebar">
                    <aside id="sidebar" class="sidebar-white">
                        
                        <div class="widget widget-range">
                            <div class="widget-body">
                                <form>
                                    <div class="range-block">
                                        <h4>Price range</h4>
                                        <div id="slider-price"></div>
                                        <div class="clearfix range-text">
                                            <input type="text" class="pull-left range-input text-left" id="min-price" readonly >
                                            <input type="text" class="pull-right range-input text-right" id="max-price" readonly >
                                        </div>
                                    </div>
                                    <div class="range-block">
                                        <h4>Area Size</h4>
                                        <div id="slider-size"></div>
                                        <div class="clearfix range-text">
                                            <input type="text" class="pull-left range-input text-left" id="min-size" readonly >
                                            <input type="text" class="pull-right range-input text-right" id="max-size" readonly >
                                        </div>
                                    </div>
                                    <div class="range-block rang-form-block">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input class="form-control" name="keyword" placeholder="Search" type="text" ng-model="searchInput">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-live-search="false" data-live-search-style="begins" title="Property Type">
                                                        <option>Property Type 1</option>
                                                        <option>Property Type 2</option>
                                                        <option>Property Type 3</option>
                                                        <option>Property Type 4</option>
                                                        <option>Property Type 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-live-search="false" data-live-search-style="begins" title="Beds" ng-model="bedroomAmount">
                                                        <option value="!!">All</option>
                                                        <option value="1">Beds 1</option>
                                                        <option value="2">Beds 2</option>
                                                        <option value="3">Beds 3</option>
                                                        <option value="4">Beds 4</option>
                                                        <option value="5">Beds 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-live-search="false" data-live-search-style="begins" title="Baths">
                                                        <option>Baths 1</option>
                                                        <option>Baths 2</option>
                                                        <option>Baths 3</option>
                                                        <option>Baths 4</option>
                                                        <option>Baths 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-live-search="false" data-live-search-style="begins" title="Property type">
                                                        <option>Type 1</option>
                                                        <option>Type 2</option>
                                                        <option>Type 3</option>
                                                        <option>Type 4</option>
                                                        <option>Type 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <select class="selectpicker" data-live-search="false" data-live-search-style="begins" title="Status">
                                                        <option>Status 1</option>
                                                        <option>Status 2</option>
                                                        <option>Status 3</option>
                                                        <option>Status 4</option>
                                                        <option>Status 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <button type="submit" class="btn btn-secondary btn-block"> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="widget widget-featured">
                            <div class="widget-top">
                                <h3 class="widget-title">Featured Properties</h3>
                            </div>
                            <div class="widget-body">
                                <div class="figure-block">
                                    <figure class="item-thumb">
                                        <span class="label-featured label label-success">Featured</span>
                                        <a class="hover-effect" href="<?= base_url() ?>properties">
                                            <img src="<?= base_url() ?>public/images/home_page/prop_list_1.png" width="290" height="194" alt="thumb">
                                        </a>
                                        <figcaption class="thumb-caption clearfix">
                                            <div class="cap-price pull-left">$350,000</div>

                                            <ul class="list-unstyled actions pull-right">
                                                <li>
                                                    <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                        <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                    </span>
                                                </li>
                                            </ul>
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="figure-block">
                                    <figure class="item-thumb">
                                        <span class="label-featured label label-success">Featured</span>
                                        <a class="hover-effect" href="<?= base_url() ?>properties">
                                            <img src="<?= base_url() ?>public/images/home_page/prop_list_2.png" width="290" height="194" alt="thumb">
                                        </a>
                                        <figcaption class="thumb-caption clearfix">
                                            <div class="cap-price pull-left">$350,000</div>

                                            <ul class="list-unstyled actions pull-right">
                                                <li>
                                                    <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                        <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                    </span>
                                                </li>
                                            </ul>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>


                        <div class="widget widget-slider">
                            <div class="widget-top">
                                <h3 class="widget-title">Featured Properties Slider</h3>
                            </div>
                            <div class="widget-body">
                                <div class="property-widget-slider">
                                    <div class="item">
                                        <div class="figure-block">
                                            <figure class="item-thumb">
                                                <span class="label-featured label label-success">Featured</span>
                                                <a href="<?= base_url() ?>properties" class="hover-effect">
                                                    <img src="<?= base_url() ?>public/images/home_page/prop_list_3.png" alt="thumb">
                                                </a>
                                                <figcaption class="thumb-caption">
                                                    <div class="cap-price pull-left">$350,000</div>
                                                    <ul class="list-unstyled actions pull-right">
                                                        <li>
                                                    <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Favorite">
                                                        <i class="fa fa-heart-o"></i>
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
                                                    </ul>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="figure-block">
                                            <figure class="item-thumb">
                                                <span class="label-featured label label-success">Featured</span>
                                                <a href="<?= base_url() ?>properties" class="hover-effect">
                                                    <img src="<?= base_url() ?>public/images/home_page/prop_list_4.png" alt="thumb">
                                                </a>
                                                <figcaption class="thumb-caption">
                                                    <div class="cap-price pull-left">$350,000</div>
                                                    <ul class="list-unstyled actions pull-right">
                                                        <li>
                                                    <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Favorite">
                                                        <i class="fa fa-heart-o"></i>
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
                                                    </ul>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-recommend">
                            <div class="widget-top">
                                <h3 class="widget-title">We recommend</h3>
                            </div>
                            <div class="widget-body">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
                                                <img alt="thumb"
src="<?= base_url() ?>public/images/home_page/we_recommend_1.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <span ng-bind="property.id"></a></h3>
                                        <h4>$350,000</h4>
                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
<img alt="thumb" src="<?= base_url() ?>public/images/home_page/we_recommend_2.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <?= $mlsId ?></a></h3>
                                        <h4>$350,000</h4>
                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
<img alt="thumb" src="<?= base_url() ?>public/images/home_page/we_recommend_1.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <?= $mlsId ?></a></h3>
                                        <h4>$350,000</h4>
                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-rated">
                            <div class="widget-top">
                                <h3 class="widget-title">Most Rated Properties</h3>
                            </div>
                            <div class="widget-body">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
<img alt="thumb" src="<?= base_url() ?>public/images/home_page/most_rated_1.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <?= $mlsId ?></a></h3>
                                        <div class="rating">
                                            <span class="star-text-left">$350,000</span><span data-title="Average Rate: 4.67 / 5" class="bottom-ratings tip"><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span style="width: 70%" class="top-ratings"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></span></span>
                                        </div>
                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
<img alt="thumb" src="<?= base_url() ?>public/images/home_page/most_rated_2.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <?= $mlsId ?></a></h3>

                                        <div class="rating">
                                            <span class="star-text-left">$350,000</span><span data-title="Average Rate: 4.67 / 5" class="bottom-ratings tip"><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span style="width: 70%" class="top-ratings"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></span></span>
                                        </div>


                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?= base_url() ?>properties">
<img alt="thumb" src="<?= base_url() ?>public/images/home_page/most_rated_3.png" width="100" height="75">
                                            </a>
                                            <figcaption class="thumb-caption">

                                                <ul class="list-unstyled actions">
                                                    <li>
                                                        <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Photos">
                                                            <i class="fa fa-camera"></i> <span class="blue">12</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading"><a href="<?= base_url() ?>properties">Listing #: <?= $mlsId ?></a></h3>

                                        <div class="rating">
                                            <span class="star-text-left">$350,000</span><span data-title="Average Rate: 4.67 / 5" class="bottom-ratings tip"><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span style="width: 70%" class="top-ratings"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></span></span>
                                        </div>


                                        <div class="amenities">
                                            <p>3 beds • 2 baths • 1,238 sqft</p>
                                            <p>Single Family Home</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-categories">
                            <div class="widget-top">
                                <h3 class="widget-title">Property Categories</h3>
                            </div>
                            <div class="widget-body">
                                <ul>
                                    <li><a href="">Apartment</a> <span class="cat-count">(30)</span></li>
                                    <li><a href="">Condo</a> <span class="cat-count">(30)</span></li>
                                    <li><a href="">Single Family Home</a> <span class="cat-count">(30)</span></li>
                                    <li><a href="">Villa</a> <span class="cat-count">(30)</span></li>
                                    <li><a href="">Studio</a> <span class="cat-count">(30)</span></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--end section page body-->
