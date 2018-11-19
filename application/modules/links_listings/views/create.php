<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if( isset( $default['flash']) ) {
    echo $this->session->flashdata('item');
    unset($_SESSION['item']);
  }
  $form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
?>

<h2 style="margin-top: -5px;"><small><?= $default['page_action'] ?></small></h2>

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

</style>
<!-- form -->
<div class="row">    
  <div class="col-md-12" style="margin-top: 20px;">
          <!-- Nav tabs -->
          <div class="card">
            <ul class="nav nav-tabs nav-clr" role="tablist">
              <!-- role="presentation" class="active" -->
              <li role="presentation"><a href="#listings" aria-controls="listings" role="tab" data-toggle="tab"><i class="fa fa-user"></i>  <span>Links Properties</span></a></li>

              <li role="presentation" <?= $li_upload ?> ><a href="#upload_files" aria-controls="upload_files" role="tab" <?= $tab_toggle ?> ><i class="fa fa-upload" aria-hidden="true"></i>  <span>Upload Photos</span></a></li>

              <li role="presentation" <?= $li_upload ?> ><a href="#video_files" aria-controls="video_files" role="tab" <?= $tab_toggle ?> ><i class="fa fa-upload" aria-hidden="true"></i>  <span>Video File</span></a></li>
            </ul>


            <!-- Tab panes -->
            <div class="tab-content" style="display: block;">
              <div role="tabpanel" class="tab-pane" id="listings">
                <form id="myForm" class="form-horizontal" 
                      method="post" action="<?= $form_location ?>" >

                      <input type="hidden" id="base_url" name="base_url"
                             value="<?= $base_url ?>">
                      <input type="hidden" id="set_dir_path" name="set_dir_path"
                             value="<?= $admin_mode ?>">
                      <input type="hidden" id="cnt_errors" name="cnt_errors"
                             value="<?= $cnt_errors ?>" >
                      <input type="hidden" id="error_mess" name="error_mess"
                             value="<?= $error_mess ?>" >
                      <input type="hidden" id="show_panel" name="show_panel"
                             value="<?= $show_panel ?>" >
                      <input type="hidden" id="update" name="update_id"
                             value="<?= $update_id ?>" >                 
            
                  <?php 
                    $data['start'] = 0;
                    $data['end'] = 23;
                    $data['select_options'] = $agent_options;
                    $this->load->view( 'default_module/create_partial', $data);
                  ?>
                </form>                  
              </div>

              <div role="tabpanel" class="tab-pane" id="upload_files">
                <?php 
                  $this->load->view( 'links_listings/partial_upload', $data);    
                ?>
              </div>

              <div role="tabpanel" class="tab-pane" id="video_files">
                <?php 
                  $this->load->view( 'links_listings/partial_add_video', $data);    
                ?>
              </div>

            </div> <!-- Tab panes -->
          </div> <!-- card end -->


    <!-- //form -->
  </div>  
</div> <!-- // end row -->

