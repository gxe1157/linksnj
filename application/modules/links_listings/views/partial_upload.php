<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $arrImgNames = [];
  // $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;
?>

<div class="row">
  <div style="padding: 0px 0px 10px 20px;">  
    <button type="button" class="btn btn-primary" id="openUploadModal" > Add Image
    </button>
  </div>
</div>  

<div class="row">
  <div class="col-md-12">

      <table class="table table-striped table-bordered"
             id="table_contents" cellspacing="0" width="90%">
        <thead>
          <tr>
            <th style="width: 20%;">Image</th>
            <th style="width: 25%;">Caption</th>
            <th style="width: 20%;">Image Name</th>
            <th style="width: 10%;">Upload Date</th>
            <th style="width: 25%;">Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
            $x = 0;

            foreach( $images_list as $key => $value ) {
              $record_id = $value->id;
              $show_img  = base_url().'upload/'.$module.'/'.$value->image;

              $image_recno = $value->id;
              $remove_name  = explode("_",$value->image);
              $image_name  = $value->image;
              $image_org_name = $value->orig_name;
              $caption = $value->caption;
              
              if(!empty($image_name))
                         $arrImgNames[] = $image_org_name;
              $create_date = convert_timestamp( $value->create_date, 'datepicker_us');
          ?>
            <tr id="tr<?= $x ?>" >
              <td>
                <img src="<?= $show_img ?>"
                     id="img_<?= $x ?>"                
                     class = "img img-responsive"
                     style="width: 100%;">
              </td>

              <td class="right" id="caption_<?= $x ?>"><?= $caption ?></td>
              <td class="right" id="image_name_<?= $x ?>"><?= $image_org_name;  ?></td>
              <td class="right" id="image_date_<?= $x ?>"><?= $create_date;  ?></td>
              <td class="center">
                        <button class="btn btn-danger btn-sm"
                                id="<?= $record_id ?>|<?= $x ?>"
                                value="<?= $remove_name[1] ?>"
                                type="button"
                                onClick="javascript: remove(this)" >
                              <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                        </button>                     

                        <button  class="btn btn-info btn-sm btn-edit"
                                 id="<?= $record_id ?>|<?= $x ?>"
                                 type="button"
                                 onClick="javascript: edit(this) "> Edit Caption
                        </button>
            </td>       

            </tr>
            <?php $x++; } ?>
        </tbody>
      </table>

      <input type="hidden" name="dbf_images" id="dbf_images"
             value='<?= json_encode($arrImgNames) ?>' >
                         
  </div><!-- //col-md-12-->


</div><!-- //row-->

<div class="row">
<div class="col-md-12 ">
  <!-- use bootstrap alert codes: warning, danger etc. -->
  <a href="<?= base_url().$return_url ?>">
    <button type="button" class="btn btn-default tab-button">Cancel</button></a>
</div>
</div>


<?= $this->load->view( 'partial_upload_modal');?>