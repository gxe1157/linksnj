<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

  <script src="<?= base_url() ?>public/app/services/zillow.service.js"></script>
  <script src="<?= base_url() ?>public/app/controllers/page.controller.js"></script>



    <script type="text/javascript">

            /* ------------------------------------------------------------------------ */

            /*  BANNER SLIDER

             /* ------------------------------------------------------------------------ */





        window['schedule'] = function () {

            $('.schedule-showing-dates').slick({

                dots: false,

                infinite: false,

                speed: 300,

                slidesToShow: 3,

                slidesToScroll: 1,

            });



        }





    window['owlCarousel'] = function() {



		$(".slick-track").on("click",function($evt){

			$(".selected-date").removeClass("selected-date");

			$($evt.target).closest(".possible-date ").addClass("selected-date");

            $("#appmnt_date").val($($evt.target).closest(".possible-date ").html());

		});



        $('#property-slider').owlCarousel({

            loop: false,

            dots: true,

            slideBy: 1,

            smartSpeed: 500,

            singleItem: true,

            thumbContainerClass: 'owl-thumbs',

            nav: true,

            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],

            addClassActive: true,

            callbacks: true,

            responsive: {

                0: {

                    items: 1

                },

                320: {

                    items: 1

                },

                480: {

                    items: 1

                },

                768: {

                    items: 1

                },

                1000: {

                    items: 1

                },

                1280: {

                    items: 1

                }

            }

        });



        $(".photos-loading").hide();

    }



    </script>



    <!--start section page body-->

    <section id="section-body" ng-controller="pageController as pc">

    <!--start detail top-->

        <div class="loader" ng-show="pc.loading">Loading...</div>

        <section class="detail-top detail-top-grid ng-hide" ng-show="!pc.loading">

            <div class="container-fluid row-fluid title-details header-bar-property">

                <div class="col-sm-12">



                    <ul class="list-inline specs flex hidden-xs hidden-sm pull-right" style="margin-top: 12px;">

                        <li>

                            <h4 ng-bind="::pc.property.NUMROOMS" class="no-margin"></h4>

                            <small class="property-sub-title">Rooms</small>

                        </li>

                        <li>

                            <h4 ng-bind="::pc.property.BDRMS" class="no-margin"></h4>

                            <small class="property-sub-title">Bed</small>

                        </li>

                        <li>

                            <h4 ng-bind="::pc.property.BATHSFULL" class="no-margin"></h4>

                            <small class="property-sub-title">Bath</small>

                        </li>

                        <li>

                            <h4 ng-bind="::pc.property.PRICECURRENT | currency" class="no-margin"></h4>

                            <small class="property-sub-title">Price</small>

                        </li>

                    </ul>



                    <div class="header-left">

                        <h1 class="property-title">

                            <span ng-bind="::pc.property.STREETNUM"></span>

                            <span ng-bind="::pc.property.STREET"></span>

                            <span ng-bind="::pc.property.STREETTYP"></span> -

                            <span ng-bind="::pc.property.STYLE"></span>

                        </h1>
                        <h3>
                            <a href="<?= base_url() ?>towns?county={{pc.property.COUNTY}}&town={{pc.property.AREANAME}}" href="class="property-sub-title" ng-bind="pc.property.AREANAME + ' ' + pc.property.STATEID + ', ' + pc.property.ZIP"></a>
                            - 
                            <a href="<?= base_url() ?>county?county={{pc.property.COUNTY}}&town=All%20Towns" href="class="property-sub-title" ng-bind="pc.property.COUNTY + ' County'"></a>
                        </h3>
                    </div>



                </div>


            </div>


            <div class="row-fluid">



                <div class="detail-mediaaa row">



                    <div class="col-sm-8">

                        <div class="tab-content">

                            <div ng-show="pc.loadingPhotos" class="loader photos-loading">Loading...</div>

                            <div ng-show="!pc.property.additionalPhotos.length && !pc.loadingPhotos">

                                <img ng-src="{{pc.property.photos[0]}}" width="1423" height="603" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" />

                            </div>

                            <div id="property-slider" class="owl-carousel owl-theme grey-box" ng-show="pc.property.additionalPhotos.length">

                                <div class="item" ng-repeat="photo in pc.property.additionalPhotos">

                                    <img ng-src="{{::photo}}" width="1423" height="603" alt="Banner Image" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" />

                                </div>

                            </div>

                                        <div class="col-sm-12">

                                                <div class="pull-left">


                                                    <span class="light-font">Added </span>

                                                    <span ng-bind="pc.property.DTADD"></span> |

                                                    <span class="light-font">Status </span>

                                                    <span ng-bind="pc.property.STATUS"></span>

                                                </div>

                                                <div class="pull-right">
                                                    <img src="https://linksnj.com/public/images/njmls.jpg" style="width: 70px;height:auto;"> Listed by - <span ng-bind="pc.property.LOFFNAME"></span>
                                                </div>

                                            </div>

                        </div>



                        <div class="media-tabs">

                            <ul>

                                <li class="popup-trigger ng-hide" ng-show="pc.property.additionalPhotos.length">

                                    <a data-toggle="tab" style="width: auto; padding: 0 20px;">

                                        <i class="fa fa-camera"></i>

                                        <span ng-bind="pc.property.additionalPhotos.length + ' photos'"></span>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <!-- Schedule a showing -->



                    <div class="col-sm-4">






                        <div class="grey-box schedule-maker text-center">

                            <h2 class="text-center light-font">Schedule a showing with Links:</h2>



                            <!-- Available dates -->

                            <div class="schedule-showing-dates">

                                <div ng-repeat="date in pc.dates" ng-bind="date" class="possible-date"></div>

                            </div>



                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#pop-login">Schedule an agent</a>

                        </div>


                        <div class="grey-box schedule-maker text-center">


                            <div ng-if="!pc.currentUserId">
                               <span ng-show="pc.isFavorited && !pc.favoriteLoading">
                                    <i class="fas fa-heart"></i>
                                </span>
                                <h2><i class="fas fa-heart"></i> Want to favorite listings?</h2>

                                <a href="<?= base_url() ?>signup"> Sign up its free!</a>

                            </div>

                            <a ng-if="pc.currentUserId" ng-click="pc.favorite(pc.property.LISTINGID)" class="text-center light-font pointer">

                                <span ng-show="pc.favoriteLoading">
                                    <div class="loader">Loading...</div>
                                </span>
                                <span ng-show="pc.isFavorited && !pc.favoriteLoading">
                                    <h2><i class="fas fa-heart"></i> Favorite this property</h2>
                                </span>
                                <span ng-show="!pc.isFavorited && !pc.favoriteLoading">
                                    <h2><i class="far fa-heart"></i> Favorite this property</h2>
                                </span>
                            </a>
                        </div>

                        <!-- Presented by -->

                        <div class="schedule-showing row-fluid grey-box" ng-show="pc.agentDetails.avatar_name">

                            <div class="col-sm-6 photo-box" style="background-image:url('/upload/{{pc.agentDetails.avatar_name}}');">

                            </div>

                            <div class="col-sm-6">

                                <div>

                                    <small class="light-font">Presented by</small>

                                    <h3 class="light-font" ng-bind="pc.property.LAG1NAME"></h3>

                                    <a class="btn btn-primary" ng-href="{{}}" data-toggle="modal" data-target="#pop-login">Contact an agent</a>

                                </div>

                            </div>

                            <div class="clearfix"></div>

                        </div>


                        <div class="row-fluid grey-box text-center" ng-show="pc.property.OPENDATE && pc.property.openDateIsLaterThanToday" style="padding: 30px;">
                                <h2><i class="fas fa-calendar-alt"></i> Open House:</h2>
                                <p ng-bind="pc.property.OPENDATE"></p>

                                <a class="btn btn-primary" ng-href="{{}}" data-toggle="modal" data-target="#pop-login">Contact an agent</a>
                        </div>


                    </div>

                </div>

            </div>

        </section>

    <!--end detail top-->

    <!--start detail content-->

        <section class="section-detail-content ng-hide" ng-show="!pc.loading">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 container-contentbar">

                        <div class="detail-bar">

                            <div class="property-description detail-block">

                                <div class="detail-title">

                                    <h2 class="title-left">Description</h2>

                                    <div class="title-right">


                                    </div>

                                </div>

                                <p ng-bind="pc.property.INTERNETREMARKS"></p>

                                <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>


                            </div>

                            <div class="detail-address detail-block">

                                <div class="detail-title">

                                    <h2 class="title-left">Address</h2>

                                </div>

                                <ul class="list-three-col">

                                    <li><strong>Address:</strong> <span ng-bind="::pc.property.STREETNUM"></span> <span ng-bind="::pc.property.STREET"></span> <span ng-bind="::pc.property.STREETTYP"></span></li>

                                    <li><strong>City:</strong> <span ng-bind="pc.property.AREANAME"></span></li>

                                    <li><strong>State/Country:</strong> <span ng-bind="pc.property.STATEID"></li>

                                    <li><strong>Zip:</strong> <span ng-bind="pc.property.ZIP"></li>

                                    <li><strong>Country:</strong> United States</li>

                                    <li><strong>County:</strong> <span ng-bind="pc.property.COUNTY"></li>

                                </ul>

                            </div>

                            <div class="detail-list detail-block">

                                <div class="detail-title">

                                    <h2 class="title-left">Detail</h2>

                                    <div class="title-right">

                                        <p>Information last updated on <span ng-bind="pc.property.DTMOD"></span></p>

                                    </div>

                                </div>

                                <div class="alert alert-info">

                                    <ul class="list-three-col">

                                        <li><strong>Property ID:</strong> <span ng-bind="::pc.property.LISTINGID"></span></li>

                                        <li><strong>Price:</strong> <span ng-bind="::pc.property.PRICECURRENT"></span></li>

                                        <li><strong>Exterior:</strong> <span ng-bind="::pc.property.EXTERIOR"></li>

                                        <li><strong>Bedrooms:</strong> <span ng-bind="::pc.property.BDRMS"></span></li>

                                        <li><strong>Bathrooms:</strong> <span ng-bind="::pc.property.BATHSFULL"></span></li>

                                        <li><strong>Basement:</strong> <span ng-bind="::pc.property.BSMTDESC"></span></li>

                                        <li><strong>Garage:</strong> <span ng-bind="::pc.property.GARAGE"></span></li>

                                        <li><strong>Year Built:</strong> <span ng-bind="::pc.property.YEARBUILT"></span></li>

                                        <li><strong>Number of rooms:</strong> <span ng-bind="::pc.property.NUMROOMS"></span></li>





                                    </ul>

                                </div>

                                <div class="detail-title-inner">

                                    <h4 class="title-inner">Additional details</h4>

                                </div>

                                <ul class="list-three-col">

                                    <li><strong>Fireplace:</strong> <span ng-bind="pc.property.FIREPLACE || 'n/a'"></span></li>

                                    <li><strong>Heat:</strong> <span ng-bind="pc.property.HEATCOOL  || 'n/a'"></span></li>

                                    <li><strong>Laundry:</strong> <span ng-bind="pc.property.LAUNDRY  || 'n/a'"></span></li>

                                    <li><strong>Pets:</strong> <span ng-bind="pc.property.PETS || 'n/a'"></span></li>

                                    <li><strong>Virtual Tour:</strong> <span ng-bind="pc.property.VIRTUALTOUR || 'n/a'"></span></li>

                                    <li><strong>Flood Plain:</strong> <span ng-bind="pc.property.FLOODPLAIN || 'n/a'"></span></li>

                                    <li><strong>Association:</strong> <span ng-bind="pc.property.ASSOCIATION || 'n/a'"></span></li>

                                    <li><strong>Lifestyle:</strong> <span ng-bind="pc.property.LIFESTYLE || 'n/a'"></span></li>

                                </ul>

                            </div>



                            <div class="detail-contact detail-block">

                                <div class="detail-title">

                                    <h2 class="title-left">View on google maps</h2>

                                </div>

                                <div class="property-map-listing">

                                    <?php $this->load->view('html_head_slider'); ?>

                                </div>

                            </div>



                            <div class="detail-contact detail-block">

                                <div class="detail-title">

                                    <h2 class="title-left">Contact info</h2>

                                    <div class="title-right"><strong><a href="#">View my listing</a></strong></div>

                                </div>

                                <div class="detail-title-inner">

                                    <h4 class="title-inner">Inquire about this property</h4>

                                </div>

                                <form>

                                    <div class="row">

                                        <div class="col-sm-4 col-xs-12">

                                            <div class="form-group">

                                                <input class="form-control" placeholder="Your Name" type="text">

                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12">

                                            <div class="form-group">

                                                <input class="form-control" placeholder="Phone" type="text">

                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12">

                                            <div class="form-group">

                                                <input class="form-control" placeholder="Email" type="email">

                                            </div>

                                        </div>

                                        <div class="col-sm-12 col-xs-12">

                                            <div class="form-group">

                                                <textarea class="form-control" rows="5" placeholder="Your message..."></textarea>

                                            </div>

                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label" for="message">Are you working with a links agent? </label>
                                                    <br>
                                                    <select class="form-control" name="links_agent" id="links_agent" ng-model="pc.agentSelect" ng-init="pc.agentSelect = ''">
                                                        <option value=''>Select...</option>
                                                        <option option='yes' value="true" ng-value="true">Yes</option>
                                                        <option option='no' value="false">No</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <select class="form-control" name="availability" id="availability">
                                                    <option value="">What is your availability?</option>
                                                    <option value="2">In the Morning</option>
                                                    <option value="3">In the Afternoon</option>
                                                    <option value="4">In the Evening</option>
                                                    <option value="5">I'm Pretty Flexible</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                        <!-- btnSubmit added be Evelio -- custom.js -->
                                    <button class="btn btn-secondary btnSubmit">Request info</button>

                                </form>

                            </div>


                            <div class="row" ng-if="pc.property.PROPTYPE == '1'">

                                <div class="col-sm-12 col-lg-6">
                                    <img src="<?= base_url() ?>public/images/ad.jpg" />
                                </div>

                                <div class="col-sm-12 col-lg-6">

                                    <div class="detail-contact detail-block">

                                        <?php $this->load->view('aside/mortgage'); ?>

                                    </div>

                                </div>

                            </div>





                        </div>

                    </div>

                </div>

            </div>



            <div class="detail-contact detail-block">

                <div class="detail-title">

                    <h2 class="title-left">Nearby Listings</h2>

                </div>



            <div class="row">

                <div class="col-sm-12">

                    <div class="row grid-row">



                        <!-- loading -->

                        <div class="loader" ng-show="pc.recentLoading">Loading...</div>



                        <!-- Loop over results -->

                        <div class="col-sm-12 col-lg-4 ng-hide" ng-repeat="recent in pc.recent" ng-show="!pc.recentLoading">

                            <div class="item-wrap">

                                <div class="property-item item-grid">

                                    <div class="figure-block">

                                        <figure class="item-thumb">

                                            <div class="label-wrap hide-on-list">

                                                <div class="label-status label label-default"><span ng-bind="::recent.PROPTYPE == 4 ? 'For Rent' : 'For Sale'"></span></div>

                                            </div>

                                            <span class="label-featured label label-success">Featured</span>

                                            <div class="price hide-on-list black-bg">

                                                <h3 ng-bind="recent.PRICECURRENT  | currency:undefined:0"></h3>

                                            </div>

                                            <a href="/view-property?type={{::pc.params.type}}&id={{::recent.LISTINGID}}">

                                                <img ng-src="{{recent.photos}}" onerror="this.src='<?= base_url() ?>public/images/links-loading.jpg'" alt="thumb" >

                                            </a>

                                            <figcaption class="thumb-caption cap-actions clearfix">

                                                <div class="pull-right">

                                                    <ul class="list-unstyled actions">

                                                        <li class="share-btn">

                                                            <div class="share_tooltip fade">

                                                                <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>

                                                                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>

                                                                <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>

                                                                <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>

                                                            </div>

                                                            <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>

                                                        </li>

                                                        <li>

                                                            <span data-toggle="tooltip" data-placement="top" title="Favorite">

                                                                <i class="fa fa-heart-o"></i>

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

                                                            <span ng-bind="'Beds: ' + recent.BDRMS"></span>

                                                            <span ng-bind="'Baths: ' + recent.BATHSFULL"></span>

                                                            <span ng-bind="'Bath Partials: ' + recent.BATHSPART"></span>


                                                        </p>

                                                    </div>

                                                </div>

                                                <div class="cell">

                                                    <div class="phone">

                                                        <a href="/view-property?type={{::pc.params.type}}&id={{::recent.LISTINGID}}" class="btn btn-primary">Details <i class="fas fa-info-circle"></i></a>

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



</section>

    <!--end detail content-->

</section>

    <!--end section page body-->





