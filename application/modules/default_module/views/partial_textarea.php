				<div class="form-group">
				  <label for="<?= $field_name ?>"
				  		 class="col-sm-4 col-md-4 control-label"> <?= $label ?>
				  </label>

				  <div class="col-sm-4 col-md-5 col-lg-5">
					<textarea <?= $disabled ?>
							  class="form-control"
							  id="<?= $field_name ?>"
							  rows="<?= $rows ?>"
							  placeholder = "<?= $placeholder ?>"					
							  name = "<?= $field_name ?>"><?= trim($value) ?></textarea>
                    <!-- Show errors here -->
                    <?= form_error($field_name, '<div class="error" style="color: red;">', '</div>'); ?>
				  </div>
				</div>