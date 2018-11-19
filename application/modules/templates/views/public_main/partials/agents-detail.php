<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!--NG Home controller -->
    <script src="<?= base_url() ?>public/app/controllers/agents.controller.js"></script>

    <!--start section page body-->
    <div ng-controller="agentsController as ac">
    <section id="section-body">

        <div class="container">

            <div class="page-title breadcrumb-top">

                <div class="row">

                    <div class="col-sm-12">

                        <ol class="breadcrumb">

                            <li><a href="#"><i class="fa fa-home"></i></a></li>

                            <li class="active">Links Agents</li>

                        </ol>

                        <div class="page-title-left">

                            <h2>All Agents</h2>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-sm-12 list-grid-area container-contentbar">

                    <div id="content-area">


                        <div class="agent-listing row">

                            <div ng-repeat="agent in ac.agents | orderBy : last_name">

                            <div class="clearfix" ng-if="$index % 4 == 0"></div>

                            <div class="profile-detail-block col-sm-3">


                                <div class="schedule-showing row-fluid grey-box">

                                    <div class="col-sm-12 photo-box" ng-style="{'width':'100%', 'background-image': 'url(/links/upload/' + agent.avatar_name + ')'}">

                                </div>

                                <div class="col-sm-12">

                                    <div>

                                        <h3 class="light-font" style="margin-top:10px;" ng-bind="agent.first_name + ' ' + agent.last_name"></h3>
                                        <h4 class="light-font" ng-bind="agent.job_title"></h4>

                                        <ul id="agentContactList" class="list-unstyled light-font">

                                            <li>
                                                <a ng-bind="ng-bind="agent.phone"></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <!-- <div class="col-sm-12">
                                    <p ng-bind-html="agent.job_description"></p>
                                </div> -->
                            </div>


                            </div>
                            </div>

                        </div>


                        {{agent.funFacts}}

                        <hr>



                        <!--start Pagination-->

                        <div class="pagination-main">

                            <ul class="pagination">

                                <li class="disabled"><a aria-label="Previous" href="#"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>

                                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>

                                <li><a href="#">2</a></li>

                                <li><a href="#">3</a></li>

                                <li><a href="#">4</a></li>

                                <li><a href="#">5</a></li>

                                <li><a aria-label="Next" href="#"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>

                            </ul>

                        </div>

                        <!--start Pagination-->



                    </div>

                </div>

            </div>

        </div>

    </section>

</div>
    <!--end section page body-->



