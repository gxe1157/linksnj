<?php
 // $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
?>
        <div class="container">
        <div class='row row-eq-height'>

            <div class="col-sm-12 col-lg-6 signin-left">
                <h1 class="links-header">Account Signup</h1>
                <h3>Why Signup?</h3>
                <ul class="ml-16 pl-16">
                    <li>Connect with top agents</li>
                    <li>Favoriting Properties</li>
                    <li>Property Updates</li>
                    <li>Local Insights</li>
                    <li>Exclusive News</li>
                </ul>
            </div>
            <div class="col-sm-12 col-lg-6">
              <h3 class="links-header">Please sign in</h3><br />

              <?php echo form_open("users/signin", 'class="form-signin" id="myform"');?>

              <?php echo $message;?>
              <div class="form-group">
                <?php echo lang('login_identity_label', 'identity'); ?>
                <?php echo form_input($identity,null,array('class' => 'form-control')); ?>
              </div>
              <div class="form-group">
                <?php echo lang('login_password_label', 'password');?>
                <?php echo form_input($password,null,array('class' => 'form-control')); ?>
              </div>

              <div class="form-group">
                <?php echo lang('login_remember_label', 'remember');?>
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
              </div>

              <div class="form-group"><?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-success"');?></div>

                <p><a href="<?php echo site_url('forgot_password')?>">I forgot my password</a></p>
                <a href="<?php echo site_url('signup')?>" class="text-center">Create new account</a>

              <?php echo form_close();?>
          </div>
        </div>
        </div>