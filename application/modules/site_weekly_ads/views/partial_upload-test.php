<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $arrImgNames = [];
  // $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;
?>

<div class="row">
  <div style="padding: 0px 0px 10px 20px;">  
    <button type="button" class="btn btn-primary" id="openUploadModal" >Add Property Listing
    </button>
  </div>
</div>  

<div class="row">
  <div class="col-md-12">

      <table class="table table-striped table-bordered" cellspacing="0" width="90%">
        <thead>
          <tr>
            <th style="width: 10%;">Image</th>
            <th style="width: 8%;">Agent Name</th>            
            <th style="width: 8%;">MLS Listings Id</th>  
            <th style="width: 8%;">Status</th>                        
            <th style="width: 20%;">Property Address</th>
            <th style="width: 12%;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $x = 0;

            foreach( $images_list as $key => $value ) {
              $record_id = $value->id;
              $image_name  = $value->image;
              $listing_source = $value->listing_source;
              $remove_name  = explode("_",$value->image);
              $image_org_name = $value->orig_name;
              $property_address = '320 Street<br />City, St 07099';
              $caption = $value->caption;
              $modified_date = $value->modified_date;

              $agents = $value->agents;
              $status = $value->status;


              if(!empty($image_name))
                         $arrImgNames[] = $image_org_name;

              $show_img = $image_name ? 'upload/'.$module.'/'.$image_name : "public/images/list-default-thumb.png";
              $create_date = convert_timestamp( $create_date, 'info');
          ?>
            <tr data-index="<?= $value->id ?>" data-position="<?= $value->position ?>">
              <td>
                <img src="<?= base_url().$show_img ?>"
                     class = "img img-responsive"
                     id="previewImg_<?= $x ?>"
                     style="width: 100px; height: 100px;">
              </td>

              <td>
                <div id="agent_name"><?= $agent_options[$agents]; ?></div>
              </td>          
              <td class="right">
                <div id="caption_div"><?= $caption ?></div>
              </td>
              <td class="right">
                <div id="status_update"><?= $status_options[$status]."  | ".$record_id ?></div>
              </td>
              <td class="right" id="property_address">
                <div id="property_address"><?= $property_address ?></div>
              </td>
              <td class="center">
                        <button class="btn btn-danger btn-sm"
                                id="<?= $record_id ?>"
                                value="<?= $remove_name[1] ?>"
                                type="button"
                                onClick="javascript: remove(this)" >
                              <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                        </button>                     

                        <button  class="btn btn-info btn-sm btn-edit"
                                  id="<?= $record_id ?>|<?= $listing_source ?>"
                                  type="button"
                                  onClick="javascript: edit(this) "> Edit
                        </button>

            </td>       

            </tr>
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




<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">Close [ &times; ]</button>
        <h4 class="modal-title">File upload form</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form id="upload-image-form" class="form-horizontal"
              method='post' action='' enctype="multipart/form-data">

          <input type="hidden" id="base_url" name="base_url"
                 value = "<?= $base_url ?>" />       
          <input type="hidden" id="module" name="module"
                 value = "<?= $module ?>" />
          <input type="hidden" name="update_id" id="update_id"
                 value="<?= $update_id ?>" />
          <input type="hidden" name="rowId" id="rowId" value="" >

          <div class="form-group">
            <label class="col-sm-3 control-label" for="caption">Record ID</label>
                <div class="col-sm-2">
                    <input class="form-control"
                         type="text"
                         id="show_rowId"  readonly>
                </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="caption">Listing Source</label>
                <div class="col-sm-6">
                     <?php
                            $field_name = "listing_source"; 
                            $additional_dd_code = 'class="form-control"';
                            $additional_dd_code .=' id="'.$field_name.'"';
                                    
                            echo form_dropdown(
                                  $field_name,
                                  $listing_source_options,
                                  $listing_source, // selected option value
                                  $additional_dd_code);          
                    ?>
                     <span id="error_<?= $field_name; ?>" style="color:red; font-weight: bold;"></span>
                </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="caption">Property ID</label>
                <div class="col-sm-6">
                    <input class="form-control"
                         type="text"
                         id="caption"
                         name="caption"
                         placeholder="Enter Property ID here">
                      <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>

          <div class="form-group" id="show_status">
            <label class="col-sm-3 control-label" for="caption">Status</label>
                <div class="col-sm-6">
                     <?php
                            $field_name = "status";          
                            $additional_dd_code = 'class="form-control"';
                            $additional_dd_code .=' id="'.$field_name.'"';

                            echo form_dropdown(
                                  $field_name,
                                  $status_options,
                                  $status, // selected option value
                                  $additional_dd_code);          
                    ?>
                     <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>

          <div class="form-group" id="show_agents">
            <label class="col-sm-3 control-label" for="caption">Agents</label>
                <div class="col-sm-6">
                    <?php
                            $field_name = "agents";
                            $additional_dd_code = 'class="form-control"';
                            $additional_dd_code .=' id="'.$field_name.'"';

                            echo form_dropdown(
                                  $field_name,
                                  $agent_options,
                                  $agents, // selected option value
                                  $additional_dd_code);          
                    ?>
                     <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>

          <!-- Preview-->
          <div class="form-group">          
            <div class="col-sm-6 col-sm-offset-3" id="preview" style="display: none;">
                <img src="#"
                     class = "img img-responsive"
                     id="previewImg"
                     style="width: 100%;">
            </div>
          </div>

          <div class="form-group" id='pre_upload'>
            <label class="col-sm-3 control-label" for="caption">Select file : </label>
                <div class="col-sm-6">
                    <input type='file' name='file[]' id='imageFile' class='form-control' >
                    <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>
          <!-- Preview-->

          <!-- Button Options  -->
          <div class="form-group" id='submit_button' style="display: none;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-primary"
                      id="get_property"
                      type="button"
                      onClick="javascript: edit(this)">Submit
              </button>   
            </div>
            
          </div>

          <div class="form-group" id='update_button' style="display: none;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-primary"
                      id="updateRecord"
                      type="button"
                      onClick="javascript: update_record()">Update Record
              </button>   
            </div>
            
          </div>

          <div class="form-group" id='show_buttons' style="display: none;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-info"
                      value="Upload"
                      id="upload"
                      type="submit">Upload
              </button>   
              <button class="btn btn-default"
                      id="cancelModal"
                      type="button"
                      onClick="javascript: removeModalImage() ">Remove Image
              </button>
            </div>
            
          </div>

        </form>
      </div>
 
    </div>

  </div>
</div>
</div>
