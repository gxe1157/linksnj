<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html><html lang="en"><?php $this->load->view('html_head'); ?><body ng-app="linksApp"><!-- wrap the site --><div class="container-fluid site-wrap">    <div class="row">    <div class="column xs-12">    <header>          <?php $this->load->view('html_nav_main.php'); ?>    </header>    <div id="container">        <?php          // $this->load->view('html_aside.php');        ?>        <!-- Main Content -->        <div class="div-menu-message">            <?php                 $data = ( isset($columns) && !empty($columns) ) ? : null;                $data = ( isset($columns_not_allowed) && !empty($columns_not_allowed) ) ? : array();                $this->load->view( $view_module.'/'.$contents, $data );            ?>        </div> <!-- End Main Content -->            </div> <!-- end container -->    </div> <!-- column --></div> <!-- row --></div> <!-- wrapper --></div> <!-- menu wrapper --></div> <!-- site wrapper -->    <?php $this->load->view('html_footer'); ?>   <!--All pages --><!--     <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/modernizr.custom.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/datepicker.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/owl.carousel.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.matchHeight-min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap-select.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery-ui.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/isotope.pkgd.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.nicescroll.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/custom.js"></script> --> <!--All pages --> <!-- Contact Us --><!--     <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/modernizr.custom.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrapValidator.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/owl.carousel.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.matchHeight-min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap-select.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery-ui.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.nicescroll.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.parallax-1.1.3.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/custom.js"></script>     --><!-- Contact Us --><!-- Create Listings -->    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap-select.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/moment.js"></script>    <script type="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0N5pbJN10Y1oYFRd0MJ_v2g8W2QT74JE &callback=initMap"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/modernizr.custom.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/slick.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/mom.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/slideout.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/owl.carousel.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.matchHeight-min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery-ui.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/masonry.pkgd.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/jquery.nicescroll.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/bootstrap-datetimepicker.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/datepicker.min.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/custom.js"></script>    <script type="text/javascript" src="<?= base_url() ?>public/js/angular-bootstrap.select.js"></script>    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">	<script type="text/javascript">		new WOW().init();	</script>        <script type="text/javascript" src="<?= base_url() ?>public/app/controllers/search.controller.js"></script><!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b81d2fd755b575d"></script><!-- Create Listings --><script>  window.intercomSettings = {    app_id: "mdts8cat",    agent : "test"  };</script><script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/mdts8cat';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script></body></html>