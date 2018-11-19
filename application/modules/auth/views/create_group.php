<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  $return_url = $_SERVER['HTTP_REFERER'];

?>

<div class='row'>
<div class="col-md-4 col-md-offset-4"> 

  <div id="infoMessage"><?php echo $message;?></div>
  <div style="width:50%; margin: 0 auto;">

	<h1><?php echo lang('create_group_heading');?></h1>
	<p><?php echo lang('create_group_subheading');?></p>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open("auth/create_group");?>

	      <p>
	            <?php echo lang('create_group_name_label', 'group_name');?> <br />
	            <?php echo form_input($group_name);?>
	      </p>

	      <p>
	            <?php echo lang('create_group_desc_label', 'description');?> <br />
	            <?php echo form_input($description);?>
	      </p>

          <p><a class="btn btn-default" href="<?= $return_url ?>" role="button">Cancel</a>
		  <?php echo form_submit('submit', lang('create_group_submit_btn'),array( 'class'=>'btn btn-success'));?></p>

	<?php echo form_close();?>

    </div>

</div>
</div>
