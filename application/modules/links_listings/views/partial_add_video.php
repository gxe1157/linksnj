<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $arrImgNames = [];
?>

<div class="row">
  <div style="padding: 0px 0px 10px 20px;">  
    <button type="button" class="btn btn-primary" id="openVideoModal" >Add YouTube Video Code
    </button>
  </div>
</div>  

<div class="row">
  <div class="col-md-12">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-5">    
    <form id="show_video" >
      <input type="text" id="youtube" value="<?= trim($columns[23]['value']) ?>" style="width: 400px" readonly />
      <input type="button" id="btnPlay" value="Play" />
      <hr />
      <iframe id="video" width="420" height="315"
              frameborder="0" style="display: block" allowfullscreen></iframe>
    </form>
    </div>
  </div><!-- //col-md-12-->
</div><!-- //row-->

<?= $this->load->view( 'partial_video_modal');?>