
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
					  <th style="width: 15%">Fullname</th>
					  <th style="width: 15%">Email</th>					  
					  <th style="width: 20%">Subject</th>
					  <th style="width: 15%">Posted</th>
					  <th style="width: 5%">Status</th>					  					  					  
					  <th style="width: 5%">Action</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	// dd($columns,1);
			    	foreach( $columns->result() as $key=>$row ){
			    	 	$edit_url = base_url().'site_online_leads/create/'.$row->id;
			    	 	$remove = base_url().'site_online_leads/delete_ss_name/'.$row->id;
   	 	                $create_date = convert_timestamp( $row->create_date, 'info');
                        $opened = $row->opened;
                        if ($opened==1) {
                          $icon = '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>';
                        } else {
                          $icon = '<span style="color: orange;" class="glyphicon glyphicon-envelope" aria-hidden="true"></span>';
                        }   	 	                
			    ?>
						<tr>
							<td><?= $row->fullname ?></td>
							<td><?= $row->email ?></td>							
							<td><?= $row->subject ?></td>							
							<td style="color: blue; font-size: .9em;"><?= $create_date ?></td>
							<td style="font-size: 1.2em; text-align: center;"><?= $icon ?></td>
							<td>
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
