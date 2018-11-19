
<?php
	if( isset( $default['flash']) ) {
		echo $this->session->flashdata('item');
		unset($_SESSION['item']);
	}
	
	$form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
?>

<?php if( is_numeric($update_id) ) { ?>
	<h2 style="margin-top: -5px;"><small> Additional Options</small></h2>		
	<div class="well">
				<?php if( $update_id > 2 ){ ?>
					<a href="<?= base_url() ?>webpages/deleteconf/<?= $update_id ?>"><button type="button" class="btn btn-danger">Delete Page</button></a>
				<?php } ?>

				<a href="<?= base_url().$columns['page_url'] ?>"><button type="button" class="btn btn-default">Preview Page</button></a>
    </div>
<?php } else { ?>
<div class="well  well-sm">
	<h2 style="margin-top: 0px;"><small> Add New Webpage</small></h2>		
</div>	
<?php } ?>

<div class="row">
	<div class="col-md-12">
	<?= validation_errors("<p style='color: red;'>", "</p>") ?>
			<form class="form-horizontal" method="post"
				 action="<?= $form_location ?>" >
			  <fieldset>
				<div class="form-group">
				  <label for="page_title"
				  		 class="col-sm-2 col-md-3 control-label"> Page Title</label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
                	<input type="text"
                		   id="page_title"
                		   name="page_title"
                		   class="form-control"
                		   value="<?= $columns['page_title'] ?>">
				  </div>
				</div>

				<div class="form-group">
					<label for="page_keywords"
							 class="col-sm-2 col-md-3 control-label"> Page keywords</label>

					<div class="col-sm-4 col-md-5 col-lg-5">
						<textarea class="form-control" id="page_keywords" rows="3"
								  name = "page_keywords">
							<?= $columns['page_keywords']  ?>
						</textarea>
					</div>
				</div>

				<div class="form-group">
				  <label for="page_description"
				  		 class="col-sm-2 col-md-3 control-label"> Page Description</label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
					<textarea class="form-control" id="page_description"
							  rows="3" name = "page_description">
						<?= $columns['page_description']  ?>
					</textarea>
				  </div>
				</div>

				<div class="form-group">
				  <label for="left_side_nav"
				  		 class="col-sm-2 col-md-3 control-label"></label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
						<?php
							$checkbox_nav = $columns['left_side_nav'] == 'accept' ? true : false;
							echo form_checkbox('left_side_nav', 'accept', $checkbox_nav );
						?>
						<b>Disable</b> left side navigation bar (default settting for forms).
				  </div>
				</div>

				<div class="form-group">
				  <label for="image_repro"
				  		 class="col-sm-2 col-md-3 control-label"></label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
						<?php
							$checkbox = $columns['image_repro'] == 'accept' ? true : false ;
							echo form_checkbox('image_repro', 'accept', $checkbox );
						?>
						Activate Image Repository Directory
				  </div>
				</div>
			
				<div class="form-group">
				  <label for="status"
				  		 class="col-sm-2 col-md-3 control-label">Status</label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
						<?php
						$additional_opt = ' id = status class="form-control"';
						$options = array(
						        '' => 'Please Select....',
						        '0' => 'Active',
						        '1' => 'Inactive',
						        '2' => 'Under Construction'
						);
						echo form_dropdown('status', $options, $columns['status'], $additional_opt);
						?>
				  </div>
				</div>


				<div class="form-group">
  				  <label for="page_content"
				  		 class="col-sm-2 col-md-3 control-label"> Page Content</label>	

				  <div class="col-sm-4 col-md-5 col-lg-5">
					<textarea class="cleditor" id="page_content"
							  rows="2" name = "page_content">
						<?= $columns['page_content']  ?>
					</textarea>
				  </div>
				</div>				

				<div class="form-actions">
				  <div class="col-sm-6 col-sm-offset-0 col-md-6 col-md-offset-3">						
				  <button type="submit" class="btn btn-primary"
				  		  name="submit" value="Submit">Submit</button>
				  <button type="submit" class="btn" 
				  		  name="submit" value="Cancel">Finished</button>
				  </div>
				</div>
			  </fieldset>
			</form>
	</div><!--/span-->
</div><!--/row-->

