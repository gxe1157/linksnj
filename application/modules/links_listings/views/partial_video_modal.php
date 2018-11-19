<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- Modal -->
<div id="videoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">Close [ &times; ]</button>
        <h4 class="modal-title">YouTube File Form</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form id="video-form" class="form-horizontal">

          <input type="hidden" id="set_dir_path" name="set_dir_path"
                 value="<?= $admin_mode ?>">
          <input type="hidden" name="update_id" id="update_id"
                 value="<?= $update_id ?>" />
          <input type="hidden" id="base_url" name="base_url"
                   value = "<?= $base_url ?>" />                    
          <input type="hidden" id="module" name="module"
                   value = "<?= $module; ?>" />                    
          <input type="hidden" name="image_position" id="image_position"
                   value='' >

          <div class="form-group" id='pre_upload'>
            <label class="col-sm-3 control-label" for="video_name">YouTube file : </label>
                <div class="col-sm-6">
                    <input type='text' name='video_name' id='video_name' class='form-control' >
                    <span id="error_'+key+'" style="color:red; font-weight: bold;"></span>
                </div>
          </div>
          
          <!-- Button Options  -->
          <div class="form-group" id='update_button' style="display: block;">
            <div class="col-sm-6 col-sm-offset-3">
              <button class="btn btn-primary"
                      id="videoSubmit"
                      type="button">submit
              </button>   
            </div>
            
          </div>

        </form>
      </div>
 
    </div>

  </div>
</div>