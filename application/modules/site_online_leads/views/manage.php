
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
					  <th style="width: 10%">Fullname</th>
					  <th style="width: 13%">Email</th>					  
					  <th style="width: 5%">Appmnt Dt</th>
					  <th style="width: 10%">Posted</th>
					  <th style="width: 10%">Status</th>					  
					  <th style="width: 2%"> --- </th>					  					  			
					  <th style="width: 3%">Action</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	// dd($columns,1);
			    	foreach( $columns->result() as $key=>$row ){
			    	 	$edit_url = base_url().'site_online_leads/create/'.$row->id;
   	 	                $appmnt_date = $row->appmnt_date == '0000-00-00' ? '00/00/0000' : format_date( $row->appmnt_date);
   	 	                $create_date = convert_timestamp( $row->create_date, 'info');
   	 	                $status_code = $row->opened;
						switch ($status_code) {
						    case "1":
						    	$status = 'Pending Assingment';
                          		$icon = '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>';
								break;                          		
						    case "2":
						    	$status = $select_options[$row->select_agent].' - Pending';
                          		$icon = '<span style="color: orange;" class="glyphicon glyphicon-send" aria-hidden="true"></span>';
								break;
						    case "3":
						    	$status = $select_options[$row->select_agent].' - Expired';
                          		$icon = '<span style="color: red;" class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>';
                          		break;
						    case "4":
						    	$status = $select_options[$row->select_agent];						    
                          		$icon = '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>';
                          		break;

						    default:
						    	$status = 'New Request';
                          		$icon = '<span style="color: orange;" class="glyphicon glyphicon-envelope" aria-hidden="true"></span>';
						}
			    ?>
						<tr>
							<td><?= $row->fullname ?></td>
							<td><?= $row->email ?></td>							
							<td><?= $appmnt_date ?></td>							
							<td style="color: blue; font-size: .9em;"><?= $create_date ?></td>
							<td style="color: blue; font-size: .9em;"><?= $status ?></td>
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
