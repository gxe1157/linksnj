
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if( isset( $default['flash']) ) {
		echo '<div id="flash">';
			echo $this->session->flashdata('item');
			unset($_SESSION['item']);
		echo '</div>';
	}

    $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;	
?>


<h2 style="margin-top: -5px;"><small><?= $default['page_title'] ?></small></h2>

<!-- // Memeber Detail Panel -->
<div class="row">
	<div style="padding: 0px 0px 10px 20px;">
	    <a class ="btnSubmitForm"
	       id="Social Media Name"
	       href="<?= base_url().$this->uri->segment(1) ?>">
	      <button type="button" class="btn btn-primary">Add Social Media Name</button>
	    </a>
	</div>
</div>	

<div class="row">		
	<div class="col-md-12">
			<form id="fun_facts">
				<input type="hidden" name="base_url"
					   id="base_url" value="<?= $base_url ?>" />
      			<input type="hidden" 
      			       id="set_dir_path" name="set_dir_path" value="<?= $admin_mode ?>">
                <input type="hidden" id="id" name="id"
                       value="<?= $update_id ?>" >       			       
			</form>	

			<table id="example" class="table table-striped table-bordered">
			 <thead>
				  <tr>
					  <th style="width: 25%;">Social Media Name</th>
					  <th style="width: 35%;">URL</th>
					  <th style="width: 20%;">Posted</th>					  
					  <th style="width: 20%;">Action</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	// dd($columns,1);
			    	foreach( $columns->result() as $key=>$row ){
			    	 	$edit_url = $row->id.'/'.$row->user_id;
			    	 	$remove = base_url().'site_social_media/delete_ss_name/'.$row->id;
			    	 	$ss_name = $row->ss_name;
			    	 	$ss_url = $row->ss_url;
   	 	                $create_date = convert_timestamp( $row->create_date, 'info');

			    ?>
						<tr>
							<td class="right"><?= $ss_name ?></td>
							<td class="right"><?= $ss_url ?></td>
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
