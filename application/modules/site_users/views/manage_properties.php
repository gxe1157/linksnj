
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if( isset( $default['flash']) ) {
		echo '<div id="flash">';
			echo $this->session->flashdata('item');
			unset($_SESSION['item']);
		echo '</div>';
	}
    $admin_mode = $default['admin_mode'] == 'admin_portal' ? 0 : 1;	
?>

<div class="row">
	<div style="padding: 0px 0px 10px 20px;">
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
					  <th style="width: 5%;">ListingId</th>				  	
					  <th style="width: 35%;">Address</th>
					  <th style="width: 30%;">City St Zip</th>					  
					  <th style="width: 15%;">Status</th>					  
					  <th style="width: 15%;">Action</th>					  
				  </tr>
			  </thead>
			  <tbody>

			    <?php
			    	foreach( $properties as $row ){
			    	 	// $edit_url = $row->id.'/'.$row->user_id;
			    	 	$listingid=$row->LISTINGID;
			    	 	$address = $row->STREETNUM.' '.$row->STREETDIR.' '.$row->STREET.' '.$row->STREETTYPE;
			    	 	$citystzip = $row->AREANAME.', '.$row->STATEID.' '.$row->ZIP;
			    	 	$status = $row->STATUS;
   	 	                $create_date = convert_timestamp( $row->create_date, 'info');
			    ?>
						<tr>
							<td class="right"><?= $listingid ?></td>	
							<td class="right"><?= $address ?></td>
							<td class="right"><?= $citystzip ?></td>
							<td class="right"><?= $status ?></td>

							<td class="center">
								<button class="btn btn-info btn-sm view_property"
								   type="button"	
								   id="<?= $row->id ?>|<?= $table_name ?>";
							   	   style="margin-top: 2px; width: 75px; font-size: 12px; padding: 2px;">
							  	<i class="fa fa-pencil fa-fw"></i> View
								</button>
							</td>    							
						</tr>
			    <?php } ?>
			  </tbody>
		  </table>
	</div><!--/span-->

</div><!--/row-->
