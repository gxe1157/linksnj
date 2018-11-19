						<div class="form-group">
		  				  <label for="<?= $field_name ?>"
						  		 class="col-sm-4 col-md-4 control-label">
							<?= $label ?>						  		 
				  		  </label>	

						  <div class="col-sm-4 col-md-5 col-lg-5">
							<textarea class="cleditor"
									  id="<?= $field_name ?>"
									  name="<?= $field_name ?>"
									  rows="2"><?= trim($value) ?></textarea>						  	
	                        <!-- Show errors here -->
	                        <?= form_error($field_name, '<div class="error" style="color: red;">', '</div>'); ?>
						  </div>
						</div>											
