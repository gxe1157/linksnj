<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?>

    <script src="<?= base_url() ?>public/app/controllers/open.controller.js"></script>


    <div class="container" ng-controller="openHouseController as oh">



        <div class="page-title breadcrumb-top">



            <div class="row">



                <div class="col-sm-12">



                    <ol class="breadcrumb">



                        <li><a href="index.html"><i class="fa fa-home"></i></a>



                        </li>



                        <li class="active">Open Houses</li>



                    </ol>



                    <div class="page-title-left">



                        <h2><span ng-bind="oh.openHouses.length"></span> Open House(s)</h2>



                    </div>



                </div>



            </div>



        </div>







        <div class="row">

            <div class="col-sm-12 container-contentbar">
                <div class="property-map-listing">

                    <?php $this->load->view('html_head_slider'); ?>

                </div>
            </div>
            
            <br>


            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 container-contentbar">



                <div class="page-main">



                    <div class="white-block ">



                        <article id="post-692" class="post-692 page type-page status-publish hentry">



                            <div class="entry-content">







                                <div class="row row-fluid">



                                    <div class="col-sm-12">



                                        <div class="vc_column-inner ">



                                            <div class="wpb_wrapper">



                                                <div class="wpb_text_column wpb_content_element ">



                                                <div class="wpb_wrapper"


                                                            <div id="property-item-module" class="houzez-module property-item-module">

                                                                <div class="container-fluid">

                                                                    <div class="row">

                                                                        <div class="col-sm-12">

                                                                            <div class="row grid-list">


                                                                                <!-- loading -->

                                                                                <div class="loader" ng-show="oh.loading">Loading...</div>


                                                                                <!-- Loop over results -->

                                                                                <div class="col-sm-12 col-lg-12 ng-hide" ng-repeat="recent in oh.openHouses" ng-show="!oh.loading">

                                                                                    <div class="item-wrap">

                                                                                        <div class="property-item item-grid">

                                                                                            <div class="figure-block">

                                                                                                <figure class="item-thumb">

                                                                                                    <div class="label-wrap hide-on-list">

                                                                                                        <div class="label-status label label-default" ng-bind="::recent.PROPTYPE == '1' ? 'For Sale' : 'For Rent'"></div>

                                                                                                    </div>

                                                                                                    <span class="label-error label label-success">Open House</span>

                                                                                                    <div class="price hide-on-list black-bg">

                                                                                                        <h3 ng-bind="recent.PRICECURRENT | currency"></h3>

                                                                                                    </div>

                                                                                                    <a ng-href="{{::recent.PROPTYPE == '1' ? '/view-property?type=RES&id=' + recent.LISTINGID : '//view-property?type=RNT&id=' + recent.LISTINGID}}">

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


                                                </div>



                                            </div>



                                        </div>



                                    </div>







                                </div>



                                <!-- .entry-content -->



                        </article>



                        <!-- #post-## -->



                        </div>



                    </div>



                </div>







                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 container-sidebar ">



                    <aside id="sidebar" class="sidebar-white">



                         <?php $this->load->view('aside/side-bar'); ?>



                    </aside>



                </div>







            </div>







</section>



<!--end section page body-->