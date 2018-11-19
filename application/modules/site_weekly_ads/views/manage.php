<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if( isset( $default['flash']) ) {
		echo $this->session->flashdata('item');
		unset($_SESSION['item']);
	}


?>

<h2 style="margin-top: -5px;"><small><?= $default['page_title'] ?></small></h2>
<p style="margin-top: 30px,">
	<a href="<?= base_url().$this->uri->segment(1) ?>/create" >
		<button type="button" class="btn btn-primary"><?= $default['add_button'] ?></button></a>
</p>

<div class="row">		
	<div class="col-md-12">
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			  <thead>
				  <tr>
					  <th>Id</th>
					  <th>Headline</th>
					  <th>Head Subtext</th>
					  <th style="width:10%;">Start Date</th>
					  <th style="width:10%;">End Date</th>
					  <th style="width:8%;">Status</th>					  	
					  <th style="width:8%;">Actions</th>
				  </tr>
			  </thead>   
			  <tbody>

					<?php
						foreach( $columns->result() as $row ) {
						    if( $row->is_delete > 0 ){
						        $show_status = 'Deleted';
						        $type = "danger";
						    } else {
						        $show_status = $row->status == 2 ? 'Suspened' : 'Acitve';
						        $type = $row->status == 2 ? 'warning' : 'primary';;
						    }							
							$edit_url = base_url().$this->uri->segment(1)."/create/".$row->id;
							$start_date = convert_timestamp($row->ad_start_date, 'datepicker_us');
							$end_date = convert_timestamp($row->ad_end_date, 'datepicker_us'); ?>
								
						<tr>
							<td class="right"><?= $row->id ?></td>
							<td class="right"><?= $row->headline ?></td>
							<td class="right"><?= $row->headline_subtext ?></td>
							<td class="right"><?= $start_date ?></td>			
							<td class="right"><?= $end_date ?></td>
							<td class="right"><span class="label label-<?= $type ?>"> <?= $show_status ?> </span></td>
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