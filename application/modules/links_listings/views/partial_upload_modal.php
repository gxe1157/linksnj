<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

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

          <input type="hidden" id="set_dir_path" name="set_dir_path"
                 value="<?= $admin_mode ?>">

          <input type="hidden" name="update_id" id="update_id"
                 value="<?= $update_id ?>" />

          <input type="hidden" id="base_url" name="base_url"
                   value = "<?= $base_url ?>" />                    
          <input type="hidden" id="module" name="module"
                   value = "<?= $module; ?>" />                    

          <input type="hidden" id="manage_rowid" name="manage_rowid"
                   value = "<?= $manage_rowid; ?>" />
                   
          <input type="hidden" name="dbf_images" id="dbf_images"
                   value='<?= json_encode($arrImgNames) ?>' >
          <input type="hidden" name="rowId" id="rowId"
                   value='' >
          <input type="hidden" name="image_position" id="image_position"
                   value='' >

          <div class="form-group">
            <label class="col-sm-3 control-label" for="show_rowId">Record ID</label>
                <div class="col-sm-2">
                    <input class="form-control"
                         type="text"
                         id="show_rowId"  readonly>
                </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="model_caption">Caption</label>
                <div class="col-sm-6">
                  <textarea class="form-control"
                    id="model_caption"
                    name="model_caption"
                    rows="3"
                    placeholder="Enter description here"><?= trim($value) ?></textarea>
                    <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>

          <div class="form-group" id='pre_upload'>
            <label class="col-sm-3 control-label" for="imageFile">Select file : </label>
                <div class="col-sm-6">
                    <input type='file' name='file[]' id='imageFile' class='form-control' >
                    <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>
          
          <!-- Preview-->
          <div class="form-group" id="preview" style="display: block;">          
            <div class="col-sm-8 col-sm-offset-2">
                <img src="#"
                     class = "img img-responsive"
                     id = "modelPreviewImg"
                     style="width: 100%;">
            </div>
          </div>
          <!-- Preview-->

          <!-- Button Options  -->
          <div class="form-group" id='submit_button' style="display: none;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-info"
                      id="upload"
                      type="submit"> Upload
              </button>   
            </div>
            
          </div>

          <div class="form-group" id='update_button' style="display: none;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-primary"
                      id="updateRecord"
                      type="button">Update
              </button>   
            </div>
            
          </div>

        </form>
      </div>
 
    </div>

  </div>
</div>