<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo '----->'.$default['status'];
// dd($admin_user);
// $admin_user->id
	$this->ion_auth->clear_login_attempts('evelio@mailers.com');

# single group (by id)
	$admin = 1;
	$blog = 2;
	if ($this->ion_auth->in_group($admin)) {
  //   ddf('is admin',1);
		// quit($admin,0);
	}

# multiple groups (by id)
	// $admin = array(1, 2);
	// if (!$this->ion_auth->in_group($group))
	// {
	// 	$this->session->set_flashdata('message', 'You must be a part of group 1 or 2 to view this page');
	// 	redirect('welcome/index');
	// }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>sb-admin/css/bootstrap.css" rel="stylesheet">
 
     <!-- Add custom CSS here -->
    <link href="<?= base_url() ?>sb-admin/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet"
          href="<?= base_url() ?>sb-admin/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= base_url() ?>sb-admin/css/datatables.min.css"/>

    <link href="<?= base_url() ?>sb-admin/css/jquery.cleditor.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>

    <?php
      if( isset($custom_styles) && !empty($custom_styles) ){
          foreach ( $custom_styles as $value) {
            echo '<link rel="stylesheet" type="text/css" href="'.base_url().$value.'" />';
          }
      }          
    ?>
    
    <script type="text/javascript">
    	// Evelio 
        var SERVER = '<?php echo site_url("/")?>';
        var BASE_URI = '<?php echo BASE_URI;?>';
    </script>

  </head>

  <body>
 
    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Links Admin Panel</a> 
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
  <?php if( $this->ion_auth->logged_in() ): ?>           
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">

<!-- Dash Board -->           
            <li><a href="<?= base_url() ?>site_dashboard/welcome"><i class="fa fa-dashboard fa-lg"></i> Dashboard</a></li>

<!-- CMS Webpages -->
<!--             <li>
                <a href="<?= base_url() ?>webpages/manage""><i class="fa fa-folder fa-lg"></i> Public Websites</a>
            </li>
 -->
<!-- Blog Webpages -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-edit fa-lg" aria-hidden="true"></i></i> Blogs <b class="caret"></b></a>

              <ul class="dropdown-menu">
                <li><a href="<?= base_url() ?>blogs/posts/add">
                    <i class="fa fa-angle-double-right"></i> New Post</a></li>

                <li><a href="<?= base_url() ?>blogs/posts/index">
                    <i class="fa fa-angle-double-right"></i> List Posts</a></li>

                <li><a href="<?= base_url() ?>blogs/categories/index">
                    <i class="fa fa-angle-double-right"></i> Manage Categories </a></li>

<!--                 <li><a href="<?= base_url() ?>blogs/tags/index">
                    <i class="fa fa-angle-double-right"></i> Manage Tags </a></li>
 -->
              </ul>
            </li>

<!-- Members -->
<?php if ($this->ion_auth->in_group($admin)): ?>
            <li><a href="<?= base_url() ?>auth/index/Admin"><i class="fa fa-users fa-lg"></i> Administrators</a></li>  
            <li><a href="<?= base_url() ?>auth/index/Agents"><i class="fa fa-users fa-lg"></i> Agents</a></li>
            <li><a href="<?= base_url() ?>auth/index/Clients"><i class="fa fa-users fa-lg"></i> Clients</a></li>
            <li><a href="<?= base_url() ?>site_online_leads/manage_admin"><i class="fa fa-mail-reply fa-lg"></i> Online Leads</a></li>

<!-- Members Enquiries -->
<!-- 
            <li><a href="<?= base_url() ?>enquiries/inbox""><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Enquiries</a></li>
 -->
<!-- Marketing Settings -->
            <li class="dropdown">
              <a href="#marketing" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-info" aria-hidden="true"></i></i> Marketing <b class="caret"></b></a>

              <ul class="dropdown-menu">
                <li><a href="<?= base_url() ?>site_weekly_ads/manage_admin">
                    <i class="fa fa-angle-double-right"></i> Weekly Ad Input</a></li>
              </ul>
            </li>

<!-- Site Settings -->            

            <li class="dropdown">
              <a href="#site_settings" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-cog fa-lg"></i> Settings <b class="caret"></b></a>

              <ul class="dropdown-menu">
                <li><a href="<?= base_url() ?>site_settings/manage_admin">
                  <i class="fa fa-angle-double-right"></i> Site Settings</a></li>

                <li><a href="<?= base_url() ?>site_admin_emails/manage">
                  <i class="fa fa-angle-double-right"></i> Emails</a></li>

                <li><a href="<?= base_url() ?>site_social_media/manage_admin">
                  <i class="fa fa-angle-double-right"></i> Social Media</a></li>

                <li><a href="<?= base_url() ?>site_admin_terms_conditions/manage_admin">
                  <i class="fa fa-angle-double-right"></i> Legal-Terms-Conditions</a></li>

                <li><a href="<?= base_url() ?>links_listings/manage_admin">
                  <i class="fa fa-angle-double-right"></i> Links Listings</a></li>
              </ul>
            </li>
<?php endif; ?>
          </ul>
 <?php endif; ?>
<!-- end of leftside nav -->

          <ul class="nav navbar-nav navbar-right navbar-user" style="border: 1px #fff solid;">
<?php if(  $this->ion_auth->in_group($admin) ): ?>            
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages For Admin <span class="badge">7</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">7 New Messages</li>
                <li class="message-preview">
                  <a href="<?= base_url() ?>site_messages/create/1">
                    <span class="avatar"><img src="https://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="https://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="https://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">View Inbox <span class="badge">7</span></a></li>
              </ul>
            </li>
<?php endif; ?>

          <?php
           if( !$this->ion_auth->logged_in()) { ?>
                <li style="padding: 0px 30px 0px 0px;"><a href="<?= base_url() ?>">
                <i class="fa fa-sign-in fa-lg" aria-hidden="true"> </i> Home Page </a></li>
            <?php  } else {  ?>        
                <!-- Logged In -->
                <li class="dropdown user-dropdown" style="padding: 0px 30px 0px 0px;">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-user"></i> <?= $admin_user->username ?> <span class="label label-success"><?= $admin_user->id ?></span> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="#"><i class="fa fa-envelope">
                          </i> Send Message </a></li>
                      <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                      <li class="divider"></li>
                      <li><a href="<?= base_url() ?>auth/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
                  </ul>
                </li>
            <?php  } ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <ol class="breadcrumb">
              <li><a href="<?= base_url() ?>site_dashboard/welcome"><i class="icon-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="icon-file-alt"></i><?= $default['page_nav'] ?></li>
              <span class="pull-right"> <?= $default['is_admin'] ?> </span>
            </ol>
            <?php
                if( isset($page_url) ){
                    // echo '<h3>View page: '.$view_module.'/'.$page_url.'</h3>';
                  $this->load->view($view_module.'/'.$page_url);
                }
            ?>        
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?= base_url() ?>sb-admin/js/jquery-1.10.2.js"></script>
    <script src="<?= base_url(); ?>sb-admin/js/jquery-migrate-1.0.0.min.js"></script>
    <script src="<?= base_url() ?>sb-admin/js/bootstrap.js"></script>

    <div class="col-md-8 col-md-offset-3">
        <!-- member_app.js -->
        <?php
          if( !isset($custom_jscript) || empty($custom_jscript) ){
              $custom_jscript = ['no_jscript'];
          } else {
              foreach ( $custom_jscript as $value) { ?>
                <script src="<?= base_url() ?><?= $value ?>.js"></script>
              <?php }
          }?>
          <div>Page rendered time: {elapsed_time} seconds</div>          
  
    </div>    


  </body>
</html>