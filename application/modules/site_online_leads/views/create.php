<?php
// https://www.lipsum.com/
	if( isset( $default['flash']) ) {
	    echo $this->session->flashdata('item');
	    unset($_SESSION['item']);
	}

	$form_location = base_url().$this->uri->segment(1)."/create/".$update_id;
    $comment = ['Pending', 'Accepted', 'Re-assigned', 'Expired'];

?>

<?php if( is_numeric($update_id) ) { ?>
	<div class="row">
		<div class="col-md-12">
			<h2 style="margin-top: -5px;"><small><?= $default['page_header'] ?></small></h2>		
			<div class="well"> </div>
		</div><!-- end 12 span -->
	</div><!-- end row -->
<?php } else { ?>
	<div class="well  well-sm">
		<h2 style="margin-top: 0px;"><small><?= $default['page_header'] ?> </small></h2>		
	</div>	
<?php } ?>

<div class="row">
	<div class="col-md-12">
			<form class="form-horizontal" method="post" action="<?= $form_location ?>" >
				<input type='hidden' name='opened' value='<?= $opened ?>' />
				<input type="hidden" name="selected_status" value="<?= $selected_status ?>" />				
				<fieldset>			    
					<?php 
					  $data['start'] = 0;
					  $data['end'] = 7;
					  $data['read_only_data'] = [0,1,2,3,4,5,6];

					  $this->load->view( 'default_module/create_partial', $data);
					?>
				</fieldset>
			</form>   
	</div><!--/span-->

</div><!--/row-->
<div class="row">
	<div class="col-md-12">
		<table  class="table table-striped table-bordered" style="margin: 0 auto; width: 100%">
		 <thead>
			  <tr>
				  <th style="width: 16%;">From</th>					  
				  <th style="width: 16%;">Agent_id</th>					  				  
				  <th style="width: 16%;">Sent</th>
				  <th style="width: 16%;">Date Modified</th>
				  <th style="width: 6%;">Time Elapsed</th>				  
				  <th style="width: 8%;">Status</th>				  
			  </tr>
		  </thead>
		  <tbody>

			<?php
				$this->load->module('site_online_leads');
		    	foreach( $lead_details->result() as $key=>$row ){
 	                $sent_to_opened = $row->sent_to_opened ? convert_timestamp( $row->sent_to_opened, 'full') : ' ........ ';
   					$time_diff = $row->sent_to_opened == 0 ? time() - $row->sent_date : $row->sent_to_opened - $row->sent_date;
   					$time_elapsed = $this->site_online_leads->time_elapsed_A($time_diff);

 	                $date = convert_timestamp( $row->sent_date, 'cool'); 	                
		    ?>
				<tr>
					<td><?= $row->sent_from ?></td>
					<td><?= $select_options[$row->sent_to] ?></td>							
					<td><?= $date ?></td>							
					<td style="color: blue; font-size: .9em;"><?= $sent_to_opened ?></td>
					<td style="color: blue; font-size: .9em;  text-align: right;"><?= $time_elapsed ?></td>					
					<td style="color: blue; font-size: .9em;"><?= $comment[$row->status] ?></td>					
				</tr>				
			<?php } ?>

		  </tbody>
	  </table>


	</div><!--/span-->

</div><!--/row-->

