
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if( isset( $default['flash']) ) {
		echo '<div id="flash">';
			echo $this->session->flashdata('item');
			unset($_SESSION['item']);
		echo '</div>';
	}

    $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;	
?>


<!-- // Memeber Detail Panel -->
<div class="row">
	<div style="padding: 0px 0px 10px 20px;">
	    <a class ="btnSubmitForm"
	       id="Fun Facts"
	       href="<?= base_url().$this->uri->segment(1) ?>">
	      <button type="button" class="btn btn-primary">Add Fun Fact</button>
	    </a>
  		<a href="<?= base_url() ?>auth/index">
    		<button type="button" class="btn btn-default">Cancel</button>
    	</a>
	</div>
</div>	

<div class="row">		
	<div class="col-md-12">
			<table id="example" class="table table-striped table-bordered">
			 <thead>
				  <tr>
					  <th style="width: 40%;">Question</th>
					  <th style="width: 30%;">Answer</th>
					  <th style="width: 15%;">Posted</th>					  
					  <th style="width: 15%;">Action</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	// checkArray($columns->result(),1);
			    	foreach( $questions->result() as $row ){
			    	 	$edit_url = $row->id.'/'.$row->user_id;
			    	 	$remove = base_url().'site_users/delete_fun_fact/'.$row->id;
			    	 	$question = $row->question;
			    	 	$answer = $row->answer;
   	 	                $create_date = convert_timestamp( $row->create_date, 'info');

			    ?>
						<tr>
							<td class="right"><?= $question ?></td>
							<td class="right"><?= $answer ?></td>
							<td class="right"><?= $create_date ?></td>
							<td class="center">
								<a class="btn btn-danger btn-sm btnConfirm" id="delete-danger"
							   	style="margin-top: 2px; width: 75px; font-size: 12px; padding: 2px;"
							   	href="<?= $remove ?>">
							  	<i class="fa fa-trash fa-fw"></i> Remove
								</a>
								<a class="btn btn-info btn-sm btn-edit"
								   id="edit-<?= $edit_url ?>"
							   	   style="margin-top: 2px; width: 75px; font-size: 12px; padding: 2px;"
							   	   href="<?= $edit_url ?>">
							  	<i class="fa fa-pencil fa-fw"></i> Edit
								</a>
							</td>    							
						</tr>
			    <?php } ?>
			  </tbody>
		  </table>
	</div><!--/span-->

</div><!--/row-->
