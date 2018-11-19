<style>
  .form-style-fake{position:absolute;top:0px;}
  .form-style-base{position:absolute;top:0px;z-index: 999;opacity: 0;}
  .fake-styled-btn{
      background: #006cad;
      padding: 10px;
      color: #fff; }
</style>

<div class="row">
    <div class="col-md-2" >

        <form id="upload-image-avatar" enctype="multipart/form-data">
          <input type="hidden" id="user_avatar" value ="<?= $user_avatar ?>" >

          <!-- "../public/images/annon_user.png"  -->
          <img src="<?= base_url() ?>upload/<?= $user_avatar ?>"
               style="width: 200px; height:150px;"
               alt="avatar"
               id="previewImg">

          <!-- upload file input  -->
          <div class="col-sm-12"
               id="pre_upload"
               style="display: block">

              <input type="file"
                     id="avatar"
                     name="file"
                     class="form-control form-input form-style-base">

              <h5 id="fake-btn" class="form-input fake-styled-btn text-center">
              <span class="margin">Choose File</span></h5>
          </div>
          <!-- upload file input  -->

          <div class="caption" id="confirm_upload"
               style="display: none; margin-top: 8px; padding-bottom: 0px;">
                <a href="#" >
                    <button class="btn btn-md btn-primary btn-sm" id="upload-button"
                            type="submit">Upload image</button>
                </a>
                <a href="#" >
                   <button type="button" id='cancelImg'
                           class="btn btn-default btn-sm">Cancel</button>
                </a>
          </div>

          <div id="message"></div>
       </form>
 
    </div>   
    <div class="well well-sm col-md-9" id="show_copy" style="margin-left: 15px; height: 150px; padding: 15px; overflow-y: auto;"></div>   
</div>
