<h1><?= $headline ?></h1>

<?php
	if( isset($flash) ) echo $flash;	
?>

<div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon white edit"></i><span class="break"></span>Confirm Delete</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
				<a href="<?= base_url() ?>webpages/manage" ><i class="halflings-icon white remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<h2>Page Title: <?= $page_title ?></h2>				
		
			<p>Are you sure that you want to delete the item?</p>

			<?php echo form_open_multipart('webpages/delete/'.$update_id, array('class' => 'form-horizontal') ); ?>
			  	<fieldset>
					<div class="control-group">
							<button type="submit" class="btn btn-danger" name="submit" value="Yes - Delete Page">Yes - Delete Page.</button>
							<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
					</div>          
			  </fieldset>
			</form>   
		</div>
	</div><!-- end 12 span -->
</div><!-- end row-fluid sortable -->