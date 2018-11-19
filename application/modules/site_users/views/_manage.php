<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if( isset( $default['flash']) ) {
		echo $this->session->flashdata('item');
		unset($_SESSION['item']);
	}
?>

<h2 style="margin-top: -5px;"><small><?= $default['page_title'] ?></small></h2>
<p style="margin-top: 30px,">
<!-- 	<a href="<?= base_url('auth/create_user/') ?>" >
		<button type="button" class="btn btn-primary"><?= $default['add_button'] ?></button></a>
 -->
 </p>

<div class="row">		
	<div class="col-md-12">
			<table class="table table-condensed table-bordered table-striped table-hover" width="100%">		

			  <thead>
				  <tr>
					  <th style="width:20%;">First</th>				  	
					  <th style="width:20%;">Last</th>
					  <th style="width:21%;">Email</th>
					  <th style="width:14%;">Groups</th>							  			  
					  <th style="width:8%;">Status</th>					  					  
					  <th style="width:7%;">Actions</th>
				  </tr>
			  </thead>   
			  <tbody>

				<?php
					foreach( $users as $user ) {
					    if( $user->is_delete > 0 ){
					        $show_status = 'Deleted';
					        $type = "danger";
					    } else {
					        $show_status = $user->active == 2 ? 'Suspened' : 'Acitve';
					        $type = $user->active == 2 ? 'warning' : 'success';;
					    }							
						$edit_url = base_url().$this->uri->segment(1)."/create/".$user->id; ?>
					<tr>
						<td><?= $user->first_name ?></td>
						<td><?= $user->last_name ?></td>			
						<td><?= $user->email ?></td>
					    <td>
					      <?php foreach ($user->groups as $group):?>
					      <?= $group->name; ?><br />
					      <?php endforeach?>
					    </td>

						<td><span class="label label-<?= $type ?>"><?= $show_status ?></span></td>
						<td>
							<a class="btn btn-info btn-sm" style="font-size: 12px; padding: 0px 5px 0px 0px;" href="<?= $edit_url ?>">
								<i class="fa fa-pencil fa-fw"></i> Edit
							</a>
						</td>
					</tr>
		    	<?php } ?>			    

			  </tbody>
		  </table>            

	</div><!--/span-->
</div><!--/row-->

