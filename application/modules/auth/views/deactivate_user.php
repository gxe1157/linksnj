<div class='row'>
<div class="col-md-4 col-md-offset-4"> 

  <div id="infoMessage"><?php echo $message;?></div>

	<h1><?php echo lang('deactivate_heading');?></h1>
	<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

	<?php echo form_open("auth/deactivate/".$user->id);?>

	  <p>
	  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
	    <input type="radio" name="confirm" value="yes" checked="checked" />
	    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
	    <input type="radio" name="confirm" value="no" />
	  </p>

	  <?php echo form_hidden($csrf); ?>
	  <?php echo form_hidden(array('id'=>$user->id)); ?>

	  <p><a class="btn btn-default" href="<?= base_url('auth/index/'.$group) ?>" role="button">Cancel</a>
    	<?php echo form_submit('submit', lang('deactivate_submit_btn'), 'class="btn btn-success"');?>
      </p>

	<?php echo form_close();?>

</div>
</div>
