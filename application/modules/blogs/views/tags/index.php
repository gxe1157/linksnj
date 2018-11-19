
<div class="row">
	<div class="col-md-12">
		<div class="box">
            <div class="box-header">
                <h3 class="box-title">Tags</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<?php echo $this->session->flashdata('message');?>
            	<p><a class="btn btn-default" href="<?php echo site_url('blogs/tags/add')?>">New Category</a></p>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th style="width: 100px">Action</th>
                    </tr>
                    <?php if(!empty($tags)):?>
                    	<?php foreach($tags as $tags):?>
		                    <tr>
		                        <td><?php echo $tags['id']?></td>
		                        <td><?php echo $tags['name']?></td>
		                        <td><?php echo $tags['slug']?></td>
		                        <td>
		                        	<a href="<?php echo site_url('blogs/tags/edit/'.$tags['id'])?>"><span class="badge bg-green">edit</span></a>
		                        	<a href="<?php echo site_url('blogs/tags/delete/'.$tags['id'])?>" onclick="return confirm('Are you sure?')"><span class="badge bg-red">delete</span></a>
		                        </td>
		                    </tr>
                    	<?php endforeach;?>
                	<?php else:?>
                		<tr><td colspan="5">No record found</td></tr>
                	<?php endif;?>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <?php echo $pagination ?>
            </div>
        </div><!-- /.box -->
	</div>
</div>
