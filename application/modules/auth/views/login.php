<div class='row'>
    <div id="infoMessage"><?php echo $message;?></div>
    <div class="col-sm-6 col-sm-offset-4 col-md-4 col-md-offset-4" >
      <h3>Please sign in</h3><br />

      <?php echo form_open("auth/login", 'class="form-signin" id="myform"');?>

      <div class="form-group">
        <?php echo lang('login_identity_label', 'identity'); ?>
        <?php echo form_input($identity); ?>
      </div>

      <div class="form-group">
        <?php echo lang('login_password_label', 'password');?>
        <?php echo form_input($password); ?>
      </div>

      <div class="form-group">
        <?php echo lang('login_remember_label', 'remember');?>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
      </div>

      <div class="form-group"><?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-success"');?></div>

      <?php echo form_close();?>

      <div><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></div>
  </div>
</div>
