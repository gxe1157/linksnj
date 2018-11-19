
<?php
// https://www.lipsum.com/
	if( isset( $default['flash']) ) {
	    echo $this->session->flashdata('item');
	    unset($_SESSION['item']);
	}

	$form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
?>

<?php if( is_numeric($update_id) ) { ?>
	<div class="row">
		<div class="col-md-12">
		<h2 style="margin-top: -5px;"><small><?= $default['page_header'] ?></small></h2>		
			<div class="well">
  				<a class ="btnConfirm " id="delete-danger"
     			   href="<?= base_url().$this->uri->segment(1) ?>/delete/<?= $update_id ?>/<?= $default['username'] ?>">
    			<button type="button" class="btn btn-danger">Delete Account</button></a>
			</div>
		</div><!-- end 12 span -->
	</div><!-- end row -->
<?php } else { ?>
	<div class="well  well-sm">
		<h2 style="margin-top: 0px;"><small><?= $default['page_header'] ?> </small></h2>		
	</div>	
<?php } ?>

<div class="row">
	<div class="col-md-12">
			<form class="form-horizontal" method="post" action="<?= $form_location ?>" >
				<fieldset>			    
					<?php 
					  $data['start'] = 0;
					  $data['end'] = 4;
					  $data['select_options'] = array('' => 'Please Select....', '0' => 'Active', '1' => 'Inactive',
																	);
					  $this->load->view( 'default_module/create_partial', $data);
					?>
				</fieldset>
			</form>   
	</div><!--/span-->

</div><!--/row-->