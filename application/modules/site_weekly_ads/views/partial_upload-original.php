<?php defined('BASEPATH') OR exit('No direct script access allowed');

  $arrImgNames = [];
  $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;

  /* set this varaible for adding image */
  $completed_upload = "none";

  /* -- Member Details Banner -- */
  if( $default['admin_mode'] == 'admin_portal' ) {
      // $this->load->view( 'default_module/admin_banner');
  } else { ?>
      <div class="row">
          <div class="col-md-12 required_docs" style="margin-top: 10px; display: block;">
              <?= $alert_mess ?>
          </div>    
      </div>    
  <?php } ?>
  <!-- Member Details Banner -->        

<div class="row">
  <div class="col-md-12">

    <form id="upload-image-form" enctype="multipart/form-data">
      <input type="hidden" id="set_dir_path" name="set_dir_path"
             value="<?= $admin_mode ?>">
      <input type="hidden" id="base_url" name="base_url"
             value = "<?= $base_url ?>" />       
      <input type="hidden" id="module" name="module"
             value="<?= $module ?>" />

      <input type="hidden" name="member_id" id="member_id"
             value="<?= $member_id ?>" />

      <input type="hidden" name="update_id" id="update_id"
             value="<?= $update_id ?>" />
      <input type="hidden" name="total_boxes" id="total_boxes"
             value="<?= $num_rows ?>" /> 

      <table class="table table-striped table-bordered" cellspacing="0" width="90%">
        <thead>
          <tr>
            <th style="width: 15%;">Image</th>
            <th style="width: 20%;">Agent Name</th>            
            <th style="width: 15%;">MLS Listings Id</th>            
            <th style="width: 25%;">Property Address</th>
            <th style="width: 5%;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $x = 0;

            foreach( $images_list as $key => $value ) {
              $image_recno = $value->id;
              $image_name  = $value->image;
              $image_org_name = $value->orig_name;
              $caption = $value->caption;
              $modified_date = $value->modified_date;

              if(!empty($image_name))
                         $arrImgNames[] = $image_org_name;

              $show_img = $image_name ? 'upload/'.$module.'/'.$image_name : "public/images/list-default-thumb.png";
              $create_date = $modified_date ? convert_timestamp( $modified_date, 'datepicker_us') : '';

              $pre_upload = $image_name == '' ? "block" : "none";
              $completed_upload = $pre_upload == "block" ? "none" : "block";
          ?>
            <tr>
              <td>
                <img src="<?= base_url().$show_img ?>"
                     class = "img img-responsive"
                     id="previewImg_<?= $x ?>"
                     style="width: 100%;">
              </td>

              <td>
                <div style="border: 0px red solid; width: 200px;">
                <?php
                  if( empty($image_org_name) ){
                  $additional_dd_code = 'class="form-control"';
                  $additional_dd_code .=' id="'.$field_name.'"';

                  echo form_dropdown(
                        $field_name,
                        $options,
                        $value, // selected option value
                        $additional_dd_code);
                }else{
                    echo "Agent name goes here...";
                }

                ?>
                </div>
                </div>
                    <!-- Show errors here -->
                    <?= form_error($field_name, '<div class="error" style="color: red;">', '</div>'); ?>
                </div>
              </td>          
              <td class="right">
                <?php if( empty($image_org_name) ) : ?>
                            <input class="form-control"
                                   type="text"
                                   id="caption_<?= $x ?>"
                                   placeholder="Enter MLS Id here">
                <?php else: ?>
                    <?= $caption ?>
                <?php endif; ?>
              </td>

              <td class="right" id="image_name_<?= $x ?>">320 Street<br />City, State 10001 </td>

              <td class="right">

                <!-- upload file input -->
                <div id="pre_upload_<?= $x ?>" style="display:<?= $pre_upload ?>" >
                        <input type="file" name="file[]" id="imageFile_<?= $x ?>" />
                </div>
                <!-- upload file input -->

                <div id="completed_upload_<?= $x ?>" style="display:<?= $completed_upload ?>">
                    <a href="#" >
                        <button class="btn btn-danger btn-sm"
                                id="removeImg_<?= $x ?>"
                                value="<?= $image_recno ?>"
                                type="button"
                                onClick="javascript: remove(this)" >
                              <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                        </button>                                
                    </a>
                    <p><?= $image_org_name;  ?></p>
                    <p><?= $create_date;  ?></p>

                </div>
                <div id="confirm_upload_<?= $x ?>" style="display:none">
                      <a href="#" >
                          <button class="btn btn-sm btn-primary"
                                  id="upload-button_<?= $x ?>"
                                  type="submit"
                                  onClick="javascript: upload_image(this)">Upload image
                          </button>
                      </a>
                      <a href="#" >
                         <button  class="btn btn-sm btn-default"
                                  id="cancelImg_<?= $x ?>"
                                  type="button"
                                  onClick="javascript: cancel(this) ">Cancel</button>
                      </a>
                </div>
                <div id="message_<?= $x ?>"></div>
              </td>
            </tr>

            <input type="hidden" name="role[]" id="role_<?= $x ?>" value="" />
            <?php $x++; } ?>

            <input type="hidden" name="dbf_images" id="dbf_images"
                   value='<?= json_encode($arrImgNames) ?>' >

        </tbody>
      </table>
    </form>

  </div><!-- //col-md-12-->


</div><!-- //row-->

<div class="row">
<div class="col-md-12 ">
  <!-- use bootstrap alert codes: warning, danger etc. -->
  <a href="<?= base_url().$return_url ?>">
    <button type="button" class="btn btn-default tab-button">Cancel</button></a>
</div>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Upload file</button>

<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">File upload form</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form method='post' action='' enctype="multipart/form-data">
          Select file : <input type='file' name='file' id='file' class='form-control' ><br>
          <input type='button' class='btn btn-info' value='Upload' id='upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
 
    </div>

  </div>
</div>
</div>
