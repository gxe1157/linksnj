<div class="row">
	<div class="col-md-12">
		 <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Edit Tag</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<?php echo site_url('blogs/tags/edit')?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tag['id']?>">
                <div class="box-body">
                    <?php echo $this->session->flashdata('message');?>
                    <?php echo validation_errors(); ?>
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" name="name" class="form-control" id="category_name" placeholder="Name" value="<?php echo set_value('name', isset($tag['name']) ? $tag['name'] : '') ?>">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button> 
                    <button type="button" class="btn btn-default" onclick="javascript:history.back()">Back</button>
                </div>
            </form>
        </div><!-- /.box -->
	</div>
</div>