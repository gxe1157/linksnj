
							<div class="form-group">
							  <label for="<?= $field_name ?>" class="col-sm-4 col-md-4 control-label">
							  		<?= $label ?>
 					  		  </label>
							  <div class="col-sm-6 col-md-5 inputGroupContainer">
							  	<div class="input-group">
			                        <span class="input-group-addon">
			                          <i class="glyphicon glyphicon-<?= $icon ?>"></i>
			                        </span>
		                            <?php
		                              $additional_dd_code = 'class="form-control"';
		                              $additional_dd_code .=' id="'.$field_name.'"';

		                              echo form_dropdown(
		                                    $field_name,
											$options,
		                                    $value, // selected option value
		                                    $additional_dd_code);
		                            ?>
	                        	</div>
			                        <!-- Show errors here -->
			                        <?= form_error($field_name, '<div class="error" style="color: red;">', '</div>'); ?>
			                  </div>
							</div>  
