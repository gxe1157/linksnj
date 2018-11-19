<?php
 // $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
?>

        <div class="container">

        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>Sign up to Links today!!</h2>
                <h3>Start Favoriting properties, hear exclusive news and more</h3><br>
            </div>
        </div>


        <div class="row">

            <div class="col-sm-12 col-lg-6">
                <img style="width:100%" src="https://dev-thehotshotz.com/links/public/images/House_LineDrawing.png" />
            </div>

            <div class="col-sm-12 col-lg-6">
            <?php echo form_open("signup");?>
                    <?php echo $message;?>
                    <div class="form-group">
                        <?php echo lang('create_user_fname_label', 'first_name');?>
                        <?php echo form_input($first_name,null,array('class' => 'form-control'));?>
                    </div>
                    <div class="form-group">
                        <?php echo lang('create_user_lname_label', 'last_name');?> 
                        <?php echo form_input($last_name,null,array('class' => 'form-control'));?>
                    </div>
                    <div class="form-group">
                        <?php echo lang('create_user_email_label', 'email');?> 
                        <?php echo form_input($email,null,array('class' => 'form-control'));?>
                    </div>
                    <div class="form-group">
                        <?php echo lang('create_user_phone_label', 'phone');?> 
                        <?php echo form_input($phone,null,array('class' => 'form-control'));?>
                    </div>
                    <div class="form-group">
                        <?php echo lang('create_user_password_label', 'password');?> 
                        <?php echo form_input($password,null,array('class' => 'form-control'));?>
                    </div>
                    <div class="form-group">    
                       <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> 
                        <?php echo form_input($password_confirm,null,array('class' => 'form-control'));?>
                    </div>

                <div class="form-group"><?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-success"');?></div>
                 <a href="<?php echo site_url('signin')?>" class="text-center">I already have account</a>
              <?php echo form_close();?>
          </div>
        </div>
        </div>
