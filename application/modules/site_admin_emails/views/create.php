
<?php
	if( isset( $default['flash']) ) {
	    echo $this->session->flashdata('item');
	    unset($_SESSION['item']);
	}

	$form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
?>

<?php if( is_numeric($update_id) ) { ?>
	<div class="row">
		<div class="col-md-12">
		<h2 style="margin-top: -5px;"><small>Update Email Details</small></h2>		
			<div class="well">
			  <a class ="btnConfirm " id="delete-danger"
     			 href="<?= base_url().$this->uri->segment(1) ?>/delete/<?= $update_id ?>">
    			<button type="button" class="btn btn-danger">Delete Account</button></a>
			</div>
		</div><!-- end 12 span -->
	</div><!-- end row -->
<?php } else { ?>
	<div class="well  well-sm">
		<h2 style="margin-top: 0px;"><small> Add New Email </small></h2>		
	</div>	
<?php } ?>


<div class="row">
	<div class="col-md-12">
	<?= validation_errors("<p style='color: red;'>", "</p>") ?>

			<form class="form-horizontal" method="post" action="<?= $form_location ?>" >
				<fieldset>			    
					<?php
				
						foreach( $columns as $key => $value ) {
							if( in_array($key, $columns_not_allowed ) === false ) {

						if($labels[$key] == "Body"){ ?>
							<div class="form-group">
			  				  <label for="page_content"
							   		class="col-sm-2 col-md-3 control-label"> Email Body
							  </label>	

							  <div class="col-sm-6 col-sm-offset-0 col-md-6">
								<textarea class="cleditor"
								          id="textarea2"
										  rows="3"
										  name = "body">
											  <?= nl2br($value) ?>
								</textarea>
							  </div>
							</div>

						<?php }	else { ?>	
							<div class="form-group">
							  <label for="<?= $key ?>"
							  		 class="col-sm-2 col-md-3 control-label"><?= $labels[$key] ?></label>

							  <div class="col-sm-4 col-md-4 col-lg-4">
	                        	<input type="text"
	                        		   id="<?= $key ?>"
	                        		   name="<?= $key ?>" 
	                        		   class="form-control"
	                        		   value="<?= $value ?>">
						  		  
							  </div>
							</div>
						<?php } ?>

			    	<?php } } ?>
					<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-3">
		                <ul class="list-inline">
			                <li><button type="submit" class="btn btn-primary"
			                			name="submit" value="Submit">Submit</button></li>                                                              
			                <li><button type="submit" class="btn" 
			                			name="submit" value="Cancel">Cancel</button></li>
		            	</ul>
		            </div>	


			  </fieldset>
			</form>   
	</div><!--/span-->

</div><!--/row-->