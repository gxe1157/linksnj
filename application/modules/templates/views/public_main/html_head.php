<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!--Head Start-->

<head>

    <title>Links Residential Real Estate</title>

    <!--Meta tags-->

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="Links Residential Real Estate">

    <meta name="description" content="Links Residential Real Estate">



    <link rel="apple-touch-icon" sizes="144x144"

          href="<?= base_url() ?>favicon.ico">

    <link rel="icon" type="image/png"

          href="<?= base_url() ?>favicon.ico" sizes="32x32">

    <link rel="icon" type="image/png" 

          href="<?= base_url() ?>favicon.ico" sizes="16x16">

    <link rel="manifest" 

          href="<?= base_url() ?>public/images/favicons/manifest.json">

    <link rel="mask-icon" 

          href="<?= base_url() ?>public/images/favicons/safari-pinned-tab.svg" color="#5bbad5">






    <meta name="theme-color" content="#ffffff">


<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">



        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.4/es6-sham.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.4/es6-shim.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.4/es6-shim.min.js"></script>


    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>



    <!-- Angular goodness -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.6/angular.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.5.6/angular-sanitize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.6/angular-animate.min.js"></script>

    <script src="<?= base_url() ?>public/js/matchHeight.js"></script>

    <script src="<?= base_url() ?>public/app/app.js"></script>
    <script src="<?= base_url() ?>public/app/filters/sanitize.js"></script>
    <script src="<?= base_url() ?>public/app/services/links.service.js?v=123"></script>

    <script src="<?= base_url() ?>public/app/controllers/agent-select.controller.js"></script>


    <?php $this->load->view('partials/current-user'); ?>


    <link href="<?= base_url() ?>public/css/bootstrap.css" 

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/bootstrap-select.css" 

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/font-awesome.css" 

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/slick.css"

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/slick-theme.css"

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/owl.carousel.css" 

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/animate.css" 

          rel="stylesheet" type="text/css" />          

    <link href="<?= base_url() ?>public/css/jquery-ui.css" 

          rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>public/css/styles.css" 

          rel="stylesheet" type="text/css" />



    <style type="text/css">

        [ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}

    </style>

</head>



<!-- contact an agent -->

<div class="modal fade" id="pop-login" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body login-block">
                <h3 class="light-font text-center">Contact an agent - contact form</h3>
                <p>It's free with no obligation - cancel anytime</p>

                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        <form name="contactform" >
                         <div class="form-group field-group">
                                <div class="input-icon input-calendar" id="datepicker">
                                    <input type='text' class="form-control" name="appmnt_date" id="appmnt_date" placeholder="Date">
                        <div class='appmnt_date' style="color:red; font-weight: regular;"></div>
                                </div>
                                <div class="input-icon input-user">
                                    <input name="fullname" id="fullname" placeholder="Full Name">
                        <div class='fullname' style="color:red; font-weight: regular;"></div>
                                </div>
                                <div class="input-email input-icon">
                                    <input name="email" id="email" placeholder="Email">
                        <div class='email' style="color:red; font-weight: regular;"></div>
                                </div>
                                <div class="input-icon input-phone">
                                    <input name="phone" id="Phone" placeholder="Phone">
                        <div class='phone' style="color:red; font-weight: regular;"></div>
                                </div>
                                <div>
                                    <textarea class="form-control" name="message" id="message" placeholder="Questions / Comments" rows="3"></textarea>
                        <div class='message' style="color:red; font-weight: regular;"></div>
                                </div>
                                <div style="margin: 20px 0;" class="text-center">
                                    Are you working with a links agent? <br>
                                    <select class="form-control" name="links_agent" id="links_agent" ng-model="pc.agentSelect" ng-init="pc.agentSelect = ''">
                                        <option value=''>Select...</option>
                                        <option option='yes' value="true" ng-value="true">Yes</option>
                                        <option option='no' value="false">No</option>
                                    </select>
                        <div class='links_agent' style="color:red; font-weight: regular;"></div>
                                </div>

                            <div style="margin: 20px 0;" class="text-center" ng-controller="agentSelectController as asc">
                                    <select class="form-control" name="select_agent" id="select_agent" ng-show="pc.agentSelect == 'true'">
                                        <option ng-repeat="agent in asc.agentsSelect" value="{{agent.user_id}}" ng-bind="agent.first_name + ' ' + agent.last_name"></option>
                                    </select>

                                <div style="margin: 20px 0;" class="text-center">
                                  <select class="form-control" name="availability" id="availability">
                                    <option value="">What is your availability?</option>
                                    <option value="2">In the Morning</option>
                                    <option value="3">In the Afternoon</option>
                                    <option value="4">In the Evening</option>
                                    <option value="5">I'm Pretty Flexible</option>
                                  </select>



                        <div class='availability' style="color:red; font-weight: regular;"></div>
                                </div>
                        <div class='select_agent' style="color:red; font-weight: regular;"></div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-block btnSubmit" value="Submit">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <div id="site-wrapper" class="<?php echo $this->router->fetch_class() ?>">
  <div id="site-canvas">

<div id="site-menu">
  <div class="side-logo">
    <a href="<?= base_url() ?>"><img src="<?= base_url() ?>public/images/Links%20Real%20Estate.svg" alt="logo"></a>
  </div>
  <section>
    <h4>
      <a href="#" data-toggle="modal" data-target="#pop-login">
        <i class="fas fa-user"></i>Contact an agent!
      </a>
    </h4>
  </section>
<hr />
<hr />





    <section>

        <h4>Homes for sale</h4>

        <ul class="sub-menu">

            <li>
                <a href="

                   <?= base_url() ?>open-houses">

                    Open Houses

                </a>
            </li>
        </ul>

        <hr />

        <hr />



        <h4>More Info</h4>



        <ul class="sub-menu">

            <li>

                <a href="

                   <?= base_url() ?>about-us">

                    About

                </a>

            </li>

            <li>

                <a href="

                    <?= base_url() ?>buyer-faqs">

                    Buyer FAQS

                </a>

            </li>

            <li>

                <a href="

                    <?= base_url() ?>seller-faqs">

                    Seller FAQS

                </a>

            </li>

            </ul>

</section>



<hr />

<hr />





    <section>

        <h4>Coming soon</h4>



        <ul class="sub-menu">

            <li>

                <a href="

                   <?= base_url() ?>ny">

                    Links NYC

                </a>

            </li>

            <li>

                <a href="

                    <?= base_url() ?>commercial">

                    Links Commercial Real Estate 

                </a>

            </li>

            <li>

                <a href="

                    <?= base_url() ?>property-management">

                    Links Property Management 

                </a>

            </li>

            </ul>

</section>





  

</div>



    <div class="modal fade" id="pop-reset-pass" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-sm">

        <div class="modal-content">

            <div class="modal-header">

                <ul class="login-tabs">

                    <li class="active">Reset Password</li>

                </ul>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>

            </div>

            <div class="modal-body">

                <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>

                <form>

                    <div class="form-group">

                        <div class="input-user input-icon">

                            <input placeholder="Enter your username or email" class="form-control">

                        </div>

                    </div>

                    <button class="btn btn-primary btn-block">Get new password</button>

                </form>

            </div>

        </div>

    </div>

    </div>

    <!-- model signin / register -->



<!--Head End-->





