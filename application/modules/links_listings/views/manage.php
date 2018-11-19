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
					  <th style="width: 10%;">ListingId</th>
					  <th style="width: 10%;">Date Listed</th>					  
					  <th style="width: 25%;">Address</th>
					  <th style="width: 20%;">City St Zip</th>					  
					  <th style="width: 15%;">Status</th>					  
					  <th style="width: 15%;">Action</th>					  
				  </tr>
			  </thead>   
			  <tbody>

					<?php
						foreach( $columns->result() as $row ) {
					        $show_status = $row->status == 2 ? 'Suspened' : 'Acitve';
					        $type = $row->status == 2 ? 'warning' : 'primary';
							$edit_url = base_url().$this->uri->segment(1)."/create/".$row->id;
							$citystzip = $row->city.', '.$row->state.' '.$row->zip;		
							$date_listed = convert_timestamp($row->date_listed, 'datepicker_us');
					?>
								
						<tr>
							<td class="right"><?= $row->id ?></td>
							<td class="right"><?= $row->listingid ?></td>
							<td class="right"><?= $date_listed ?></td>
							<td class="right"><?= $row->address ?></td>
							<td class="right"><?= $citystzip ?></td>			
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