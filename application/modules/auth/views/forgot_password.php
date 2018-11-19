<div class='row'>
<div class="col-md-4 col-md-offset-4"> 

  <div id="infoMessage"><?php echo $message;?></div>
 	<h1><?php echo lang('forgot_password_heading');?></h1>
	<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />

      <?php echo form_input( 
        array( 'type' => 'text',
               'name'=> 'identity',
               'id'=> 'identity',
               'class'=> 'form-control') ); ?>      	
      </p>

      <p><a class="btn btn-default" href="login" role="button">Cancel</a>
  		 <?php echo form_submit('submit', lang('forgot_password_submit_btn'),
      							 array( 'class'=>'btn btn-success'));?>
	  </p>
	<?php echo form_close();?>

</div>
</div>

