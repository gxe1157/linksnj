<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if( isset( $default['flash']) ) {
	  echo $this->session->flashdata('item');
	  unset($_SESSION['item']);
	}
	$form_location = base_url().$this->uri->segment(1)."/update_password/".$update_id;
?>

<h2 style="margin-top: -10px;"><small>Reset Password </small></h2>
<hr>

<div class="row">
	<div class="col-xs-12 col-md-3 col-md-offset-4">
		<div class="container">
			<form class="form-horizontal" method="post" action="<?= $form_location ?>" >
				<fieldset>			    
					<div class="form-group">
                    <div class="col-xsm-4 col-sm-6 col-md-4">
					  <label class="control-label" for="typeahead">Password </label>
						<input type="password" class="form-control" name = "password">
						<div style="color: red; "><?php echo form_error('password'); ?></div>
					  </div>
					</div>
					<div class="form-group">
                    <div class="col-xsm-4 col-sm-6 col-md-4">
					  <label class="control-label" for="typeahead">Confirm Password </label>
						<input type="password" class="form-control" name = "confirm_password">
						<div style="color: red; "><?php echo form_error('confirm_password'); ?></div>
					  </div>
					</div>
					<div class="form-actions">
					  <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
					  <button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>
				</fieldset>
			</form>   

		</div>
	</div><!--/span-->
</div><!--/row-->
