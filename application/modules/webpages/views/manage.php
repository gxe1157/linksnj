
<?php
	if( isset( $default['flash']) ) {
		echo $this->session->flashdata('item');
		unset($_SESSION['item']);
	}
?>

<h2 style="margin-top: -5px;"><small><?= $default['headline'] ?></small></h2>
<p style="margin-top: 30px,">
	<a href="<?= base_url().$this->uri->segment(1) ?>/create" >
		<button type="button" class="btn btn-primary"><?= $default['add_button'] ?></button></a>
</p>

<div class="row">		
	<div class="col-md-12">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			 <thead>
				  <tr>
					  <th>Page URL</th>
					  <th>Page Title</th>
					  <th>Actions</th>
					  <th>Status</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	 foreach( $columns->result() as $row ){
			    	 	$edit_url = $redirect_url."/".$row->id;
			    	 	$view_url =base_url().$row->page_url;
			    ?>
						<tr>
							<td class="right"><?=  $view_url ?></td>
							<td class="right"><?= $row->page_title ?></td>
							<td class="right"><?= $status_mess[$row->status] ?></td>
							<td class="center">
								<a class="btn btn-success btn-sm" style="font-size: 12px; padding: 0px 5px 0px 0px;" href="<?= $view_url ?>">
									<i class="fa fa-eye fa-fw"></i> View
								</a>
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
