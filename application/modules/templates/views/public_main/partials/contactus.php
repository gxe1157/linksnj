<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="header-media">
        <div class="page-banner-image banner-single-item">
            <div class="banner-inner banner-page-title banner-parallax" style="background-image: url(<?= base_url() ?>/public/images/sketch.jpg);">
                <div class="banner-caption">
                    <h1>Contact us</h1>
                    <h2>Why Choose Links Residential</h2>
                </div>
            </div>
        </div>
    </div>

    <!--start section page body-->
    <section id="section-body">
        <div class="container">
            <div class="page-title breadcrumb-top">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                            <li class="active">Contact</li>
                        </ol>
                        <div class="page-title-left">
                            <h2>Contact</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div id="content-area" class="contact-area">
                        <div class="white-block">
                            <div class="row">
                                <div class="col-sm-5 col-xs-12 contact-block-inner">
                                    <form id="contact_form">
<!--                                         <div class="form-group">
                                            <label class="control-label" for="appmnt_date">Date</label>
                                            <input name="appmnt_date" id="appmnt_date" placeholder="Date">
                                        </div> -->
                                        <div class="form-group">
                                            <label class="control-label" for="fullname">Full Name</label>
                                            <input class="form-control" name="fullname" id="fullname">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="email">Your email</label>
                                            <input class="form-control" name="email" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="phone">Your Phone</label>
                                            <input class="form-control" name="phone" id="phone">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="subject">Subject</label>
                                            <input class="form-control" name="subject" id="subject">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="message">Your Message</label>
                                            <textarea class="form-control" name="message" rows="4" id="message"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="links_agent">Are you working with a links agent? </label>
                                                <br>
                                                <select class="form-control" name="links_agent" id="links_agent" ng-model="pc.agentSelect" ng-init="pc.agentSelect = ''">
                                                    <option value=''>Select...</option>
                                                    <option option='yes' value="true" ng-value="true">Yes</option>
                                                    <option option='no' value="false">No</option>
                                                </select>
                                                <br>
                                                <select class="form-control" name="select_agent" id="select_agent" ng-show="pc.agentSelect == 'true'">
                                                    <option value="">Select an agent</option>
                                                    <option value="1">Alain Spira</option>
                                                    <option value="2">Aleshia Jijon</option>
                                                    <option value="3">Alicia Pugh</option>
                                                    <option value="4">Brigitte Hauyon</option>
                                                    <option value="5">Bruce Elichman</option>
                                                    <option value="6">Carlos Ortiz</option>
                                                    <option value="7">Carol Urena</option>
                                                    <option value="8">Cathy Denis</option>
                                                    <option value="9">Dalia Sakai</option>
                                                    <option value="10">Dara Klatsky</option>
                                                    <option value="11">Deborah Pearlman</option>
                                                    <option value="12">Donald Callwood</option>
                                                    <option value="13">Dov Mittelman</option>
                                                    <option value="14">Gnesha Shain</option>
                                                    <option value="15">Johanna Cogan</option>
                                                    <option value="16">Julieanne DesJardins</option>
                                                    <option value="17">Kenneth Grier</option>
                                                    <option value="18">Kenneth Schwartz</option>
                                                    <option value="19">Liora Kirsch</option>
                                                    <option value="20">Luis Gutierrez</option>
                                                    <option value="21">Malka Abrahams</option>
                                                    <option value="22">Malkie Benson</option>
                                                    <option value="23">Marc Stein</option>
                                                    <option value="24">Michelle Padilla</option>
                                                    <option value="25">Michelle Wasserlauf</option>
                                                    <option value="26">Nina Eizikovitz</option>
                                                    <option value="27">Rena Strulowitz</option>
                                                    <option value="28">Roger Mejia-Lopez</option>
                                                    <option value="29">Sara Landerer</option>
                                                    <option value="30">Suzanne Packer</option>
                                                    <option value="31">Tatiana Leon</option>
                                                    <option value="32">Zeevyah Benoff</option>
                                                </select>

                                        </div>



                                        <div class="form-group">
                                            <select class="form-control" name="availability" id="availability">
                                                <option value="">What is your availability?</option>
                                                <option value="2">In the Morning</option>
                                                <option value="3">In the Afternoon</option>
                                                <option value="4">In the Evening</option>
                                                <option value="5">I'm Pretty Flexible</option>
                                            </select>
                                        </div>


                                        <!-- btnSubmit added be Evelio -- custom.js -->
                                        <button type="submit" class="btn btn-secondary btn-long btnContactus"
                                        		id="btnContactus">Send</button>
 
                                    </form>
                                </div>
                                <div class="col-sm-4 col-xs-12 contact-block-inner">
                                    <div class="contact-info-block">
                                        <h4 class="contact-info-title">Need help searching on&nbsp;Links?</h4>
                                        <p>If you&nbsp;forgot&nbsp;your password or want to change your email preferences, use the links below:</p>
                                        <ul>
                                            <li><a href="#" data-modal-target="reset-password">Forgot Password?</a></li>
                                            <li><a href="#">Edit email preferences / Unsubscribe</a></li>
                                        </ul>
                                    </div>
                                    <div class="contact-info-block">
                                        <h4 class="contact-info-title">Still need help?</h4>
                                        <p>If you didn’t find the answer to your question, please&nbsp;<a href="#">contact us</a>&nbsp;and a member of our customer support team will gladly assist you.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!--end section page body-->











