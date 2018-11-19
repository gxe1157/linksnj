<script src="<?= base_url() ?>public/app/controllers/profile.controller.js"></script>

<div ng-controller="profileController as pc" class="container-fluid">
    <div class="row">
     <div class="col-sm-12 " >
        <div id="property-item-module" class="houzez-module module-title text-center">

                <div class="row >

                    <div class="col-sm-12">

                        <h2>Your Favorited Properties</h2>

                        <h3 class="sub-heading">All your saved properties</h3><br><br>

                    </div>

                </div>

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="row grid-row">

                                <!-- loading -->

                                <div class="loader" ng-show="pc.favoritesLoading">Loading...</div>

                                <!-- Loop over results -->

                                <div class="text-center" ng-show="!pc.favoriteProperties.length && !pc.favoritesLoading">

                                    <div>
                                        <img style="max-width:200px;margin:0 auto;" src="<?= base_url() ?>public/images/empty-results.png" />
                                    </div>
                                   You have no properties favorited. Start favoriting now! :)

                                </div>

                                <div class="col-sm-12 col-lg-3 ng-hide" ng-repeat="recent in pc.favoriteProperties" ng-show="!pc.favoritesLoading">

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

                                                        <img ng-src="{{recent.photos}}" alt="thumb">

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
                <div class="clear"></div>
            </div>
    </div>