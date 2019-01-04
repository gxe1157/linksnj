
 				<div class="row">
 				<div class="col-md-12">
	 				<?php
						for($i = $start; $i < $end ; $i++ ) {
							$data['input_type'] = $columns[$i]['input_type'];						
							$data['label'] = $columns[$i]['label'];
							$data['field_name'] = $columns[$i]['field'];
							$data['placeholder'] = $columns[$i]['placeholder'];						
							$data['value'] = $columns[$i]['value'];
							$data['icon'] = $columns[$i]['icon'];

							/* Build $read_only_data at views/create.php */
							$data['disabled'] = isset($read_only_data[$i]) ? 'readonly' : null;
							switch ($data['input_type']) {
							    case "select":
							    	$data['options'] = $select_options;
							    	$this->load->view( 'default_module/partial_dropdown', $data);		
							        break;

							    case "textarea2":
									$this->load->view( 'default_module/partial_textarea2', $data);		
									break;

							    case "textarea":
							        $data['rows'] = strlen($data['value']) < 420 ? 6 :strlen($data['value']) / 70;
									$this->load->view( 'default_module/partial_textarea', $data);		
									break;

							    case "dates":
									$this->load->view( 'default_module/partial_date', $data);		
									break;

							    default:
							    	$this->load->view( 'default_module/partial_text', $data);
							}
						}	
					?>			
	            </div>

				<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-4">
	                <ul class="list-inline">
		                <li><button type="submit" 
		                			name="cancel"
		                			value="<?= $cancel ?>"
		                            class="btn btn-default" >Cancel</button></li>                                                              
		                <li><button type="submit"  
		                			name="submit"
		                			value="Submit"
		                			id="submit_btn" 
		                            class="btn btn-primary" <?= $disable_submit ?> ><?= $action ?></button></li>
	            	</ul>
				</div>
	            </div>