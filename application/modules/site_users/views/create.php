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
      <!-- Nav tabs -->
      <div class="card">
        <ul class="nav nav-tabs nav-clr" role="tablist">
          <!-- role="presentation" class="active" -->
          <li role="presentation "><a href="#agent_profile" aria-controls="user" role="tab" data-toggle="tab"><i class="fa fa-user"></i>  <span>Agent Profile</span></a></li>

          <li role="presentation" ><a href="#job_description" aria-controls="job_description" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Bio</span></a></li>

          <li role="presentation"><a href="#social_media" aria-controls="social_media" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Social Media</span></a></li>

          <li role="presentation" ><a href="#fun_facts" aria-controls="fun_facts" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Fun Facts</span></a></li>

          <li role="presentation"><a href="#rentals" aria-controls="rentals" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Rental Listings</span></a></li>

          <li role="presentation"><a href="#rentals_leased" aria-controls="rentals_leased" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Rental Leased</span></a></li>

          <li role="presentation"><a href="#properties" aria-controls="properties" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Properties For Sale</span></a></li>

          <li role="presentation"><a href="#properties_sold" aria-controls="properties_sold" role="tab" data-toggle="tab"><i class="fa fa-info" aria-hidden="true"></i>  <span>Properties Sold</span></a></li>


        </ul>

        <form id="myForm"
              class="form-horizontal"
              method="post"
              action="<?= $form_location ?>" >

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

          <!-- Tab panes -->
          <div class="tab-content" style="display: block;">


                  <div role="tabpanel" class="tab-pane" id="agent_profile">
                    <?php 
                      $data['start'] = 0;
                      $data['end'] = 10;
                      $this->load->view( 'default_module/create_partial', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="job_description">
                    <?php 
                      $data['start'] = 10;
                      $data['end'] = 14;                  
                      $this->load->view( 'default_module/create_partial', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="social_media">
                    <?php 
                      $data['start'] = 14;
                      $data['end'] = 19;                  
                      $this->load->view( 'default_module/create_partial', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="fun_facts">
                    <?php 
                      $data['start'] = null;
                      $data['end'] = null;                  
                      $this->load->view( 'manage_fun_facts', $data);
                    ?>
                  </div>

                  <!-- $data['rnt_sold'], $data['rnt_listed'], $data['res_sold'], $data['res_listed'] -->
                  <div role="tabpanel" class="tab-pane" id="rentals">
                    <?php 
                      $data['start'] = null;
                      $data['end'] = null;                  
                      $data['properties'] = $rnt_listed;
                      $data['table_name'] = 'rets_rnt';
                      $this->load->view( 'manage_properties', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="rentals_leased">
                    <?php 
                      $data['start'] = null;
                      $data['end'] = null;                  
                      $data['properties'] = $rnt_sold;
                      $data['table_name'] = 'rets_rnt_sold';
                      $this->load->view( 'manage_properties', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="properties">
                    <?php 
                      $data['start'] = null;
                      $data['end'] = null;                  
                      $data['properties'] = $res_listed;
                      $data['table_name'] = 'rets_res';                      
                      $this->load->view( 'manage_properties', $data);
                    ?>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="properties_sold">
                    <?php 
                      $data['start'] = null;
                      $data['end'] = null;                  
                      $data['properties'] = $res_sold;
                      $data['table_name'] = 'rets_res_sold';                      
                      $this->load->view( 'manage_properties', $data);
                    ?>
                  </div>

          </div> <!-- Tab panes -->

        </form>        

      </div> <!-- card end -->
  </div> <!-- // col-md-12 -->
</div> <!-- // end row -->

<!-- Modal -->
<div id="viewPropertyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">Close [ &times; ]</button>
        <h4 class="modal-title">Property Details</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form id="upload-image-form" class="form-horizontal" method='post' action=''>
          <input type="hidden" id="base_url" name="base_url" value = "<?= $base_url ?>" />
          <input type="hidden" name="rowId" id="rowId" value="" >

          <div class="form-group">
            <label class="col-sm-3 control-label" for="show_rowId">Record ID</label>
                <div class="col-sm-2">
                    <input class="form-control"
                         type="text"
                         id="show_rowId"  readonly>
                </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="caption">Property ID</label>
                <div class="col-sm-6">
                    <input class="form-control"
                         type="text"
                         id="LISTINGID"  readonly>
                </div>
          </div>

          <!-- Preview-->
          <div class="form-group" id="preview" style="display: block;">          
            <div class="col-sm-8 col-sm-offset-2">
                <img src="#"
                     class = "img img-responsive"
                     id="propertyImg"
                     style="width: 100%;">
            </div>
            <div class="col-sm-8 col-sm-offset-2">
                  <input class="form-control"
                         type="text"
                         id="address"  readonly>
            </div>
          </div>
          <!-- Preview-->
          
        </form>
      </div>
 
    </div>

  </div>
</div>


