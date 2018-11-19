<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if( isset( $default['flash']) ) {
    echo $this->session->flashdata('item');
    unset($_SESSION['item']);
  }
	$form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
?>

<div class="row">
  <div class="col-md-12">
    <?php
        if( $default['is_deleted'] ){
          $show_buttons = false;
          echo '<div class="col-md-12 alert alert-danger">
                    <strong>Alert!</strong> This user account has been Deleted.
                </div>';      
        } else if( $status == 2 ) {
          echo '<div class="col-md-12 alert alert-warning">
                    <strong>Alert!</strong> This user account has been Suspened.
                </div>';      
        }             
    ?>      
  </div> <!-- // col-md-12 -->
</div>

<!-- Member Details Banner -->
<?php 
    if( $default['admin_mode'] == 'admin_portal' ) $this->load->view( 'admin_banner')
?>
<!-- Member Details Banner -->


<!-- form -->
<div class="row">    
  <div class="col-md-12" style="margin-top: 5px;">
    <h2> Customer profile page cooming soon.....</h2>
  </div>
</div>


