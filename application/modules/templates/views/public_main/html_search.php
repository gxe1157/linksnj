<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); ?><!--start advanced search section--><section class="advanced-search advance-search-header" data-spy="affix" data-offset-top="200" ng-controller="searchController as sc">    <div class="container w-100">        <div class="row">            <div class="col-sm-12">                <form>                    <div class="form-group search-long">                        <nav class="buy-rent-menu navi main-nav text-left">                        <ul class="inline">                            <li><a ng-class="{'active-search' : sc.searchType == 'res'}" href="#" ng-click="sc.searchType = 'res'; sc.searchProperty(sc.searchQuery)" href="">Buy</a></li>                            <li><a ng-class="{'active-search' : sc.searchType == 'RNT'}" href="#" ng-click="sc.searchType = 'RNT'; sc.searchProperty(sc.searchQuery)">Rent</a></li>                        </ul>                        </nav>                        <div class="search">                            <div class="input-search input-icon">                                <input ng-model="sc.searchQuery" ng-model-options="{ allowInvalid: true, debounce: 200, }" class="form-control" type="text" placeholder="Search by address, town or county" ng-keyup="sc.searchProperty(sc.searchQuery)">                            </div>                            <div class="advance-btn-holder">                                <button class="advance-btn btn" type="button"><i class="fas fa-cog"></i> Advanced</button>                            </div>                        </div>                        <div class="search-btn">                            <button class="btn btn-primary">Go</button>                        </div>                    </div>                    <div>                    <div id="auto_complete_ajax" class="auto-complete ng-hide" ng-hide="!sc.searchQuery">                            <strong class="places-search"><i class="fas fa-map-marker-alt"></i> Places</strong>                            <ul>                                <li class="ng-hide" ng-show="sc.searchQuery && !sc.autoComplete.length && !sc.loading">                                    <span>No results found try more generic searches</span>                                </li>                                <li ng-repeat="results in sc.autoComplete">                                    <a style="display:inline" target="_self" ng-href="{{'https://linksnj.com/view-property?type=' + sc.searchType + '&id=' + results.LISTINGID}}">                                        <span ng-bind="::results.address.split(',')[0] + ', '"> </span>                                    </a>                                    <a style="display:inline" target="_self" ng-href="{{'https://linksnj.com/towns?town=' + results.AREANAME + '&county=' + results.COUNTY + '&beds=' + sc.bedrooms + '&baths=' + sc.baths + '&bathsPart=' + sc.bathsPart + '&priceMin=' + sc.priceMin + '&priceMax=' + sc.priceMax}}">                                        <span ng-bind="::results.AREANAME + ', '"> </span>                                    </a>                                    <a style="display:inline" target="_self" ng-href="{{'https://linksnj.com/county?town=All%20Towns'+ '&county=' + results.COUNTY + '&beds=' + sc.bedrooms + '&baths=' + sc.baths + '&bathsPart=' + sc.bathsPart + '&priceMin=' + sc.priceMin + '&priceMax=' + sc.priceMax}}">                                        <span ng-bind="::results.COUNTY + ' County'"> </span>                                    </a>                                </li>                            </ul>                        </div>                        <div id="auto_complete_ajax" class="auto-complete ng-hide" ng-hide="!sc.searchQuery || !sc.availableTownsFromSearch.length">                            <strong class="places-search"><i class="fas fa-map-marker-alt"></i> Towns</strong>                            <ul>                                <li ng-repeat="results in sc.availableTownsFromSearch">                                    <a style="display:inline" target="_self" ng-href="{{'https://linksnj.com/towns?town=' + results.town + '&county=' + results.county + '&beds=' + sc.bedrooms + '&baths=' + sc.baths + '&bathsPart=' + sc.bathsPart + '&priceMin=' + sc.priceMin + '&priceMax=' + sc.priceMax}}">                                        <span ng-bind="::results.town"> </span>                                    </a>                                </li>                            </ul>                        </div>                        <div id="auto_complete_ajax" class="auto-complete ng-hide" ng-hide="!sc.searchQuery || !sc.availableCountiesFromSearch.length">                            <strong class="places-search"><i class="fas fa-map-marker-alt"></i> Counties</strong>                            <ul>                                <li ng-repeat="results in sc.availableCountiesFromSearch">                                {{}}                                    <a style="display:inline" target="_self" ng-href="{{'https://linksnj.com/county?county=' + results.county + '&town=' + 'All%20Towns' + '&beds=' + sc.bedrooms + '&baths=' + sc.baths + '&bathsPart=' + sc.bathsPart + '&priceMin=' + sc.priceMin + '&priceMax=' + sc.priceMax}}">                                        <span ng-bind="::results.county"> </span>                                    </a>                                </li>                            </ul>                        </div>                    </div>                    <div class="advance-fields">                        <div class="row">                            <div class="col-sm-3 col-xs-12">                                <div class="form-group">                                    <select ng-model="sc.bedrooms" class="quick-select">                                          <option value="A">Any Bedrooms</option>                                          <option value="1">1 Bedrooms</option>                                          <option value="2">2 Bedrooms</option>                                          <option value="3">3 Bedrooms</option>                                          <option value="4">4 Bedrooms</option>                                          <option value="5">5 Bedrooms</option>                                    </select>                                </div>                            </div>                            <div class="col-sm-3 col-xs-12">                                <div class="form-group">                                    <select ng-model="sc.baths" class="quick-select">                                         <option value="A">Any Baths</option>                                         <option value="1">1 Baths</option>                                         <option value="2">2 Baths</option>                                         <option value="3">3 Baths</option>                                         <option value="4">4 Baths</option>                                         <option value="5">5 Baths</option>                                    </select>                                </div>                            </div>                            <div class="col-sm-3 col-xs-12">                                <div class="form-group">                                    <input ng-model="sc.priceMin" placeholder="price low" style="padding: 6px;" class="quick-select"></input>                                </div>                            </div>                            <div class="col-sm-3 col-xs-12">                                <div class="form-group">                                    <input ng-model="sc.priceMax" placeholder="price max" style="padding: 6px;" class="quick-select"></input>                                </div>                            </div>                        </div>                    </div>                </form>            </div>        </div>    </div></section><!--end advanced search section-->