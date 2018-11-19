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
	<?= validation_errors("<p style='color: red;'>", "</p>") ?>
	
			<table id="example" class="table table-striped table-bordered"
				   cellspacing="0" width="100%">
			  <thead>
				  <tr>
					  <th style="width: 5%">Id</th>
					  <th style="width: 50%">Title</th>
					  <th style="width: 25%">Author</th>
					  <th style="width: 10%">Date Created</th>
					  <th style="width: 10%">Actions</th>
				  </tr>
			  </thead>   
			  <tbody>

					<?php
						foreach( $columns->result() as $row ) {
							$edit_url = base_url().$this->uri->segment(1)."/create/".$row->id;
				$create_date = convert_timestamp($row->create_date, 'datepicker_us'); ?>

						<tr>
							<td class="right"><?= $row->id ?></td>
							<td class="right"><?= $row->title ?></td>
							<td class="right"><?= $row->author ?></td>
							<td class="right"><?= $create_date ?></td>
							<td class="center">
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
