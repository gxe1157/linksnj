<div class="container">
    <div class="row profile-column">

     <div class="col-sm-12 col-lg-6" >
        <h3>My Profile</h3><br />
            <!-- form start -->
            <?php echo form_open('users/profile');?>
                <input type="hidden" name="id" value="<?php echo $user['id']?>">
                <div class="box-body">
                    <?php echo $this->session->flashdata('message');?>
                    <?php echo validation_errors(); ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" readonly="readonly" name="username" class="form-control" id="username" placeholder="Username" value="<?php echo set_value('username', isset($user['username']) ? $user['username'] : '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" readonly="readonly" name="email" class="form-control" id="username" placeholder="Username" value="<?php echo set_value('email', isset($user['email']) ? $user['email'] : '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">New Password</label>
                        <input type="password" name="password" class="form-control" id="username" placeholder="New Password" value="">
                    </div>
                    <div class="form-group">
                        <label for="username">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="username" placeholder="Confirm Password" value="">
                    </div>
                    <div class="form-group">
                        <label for="username">First  Name</label>
                        <input type="text" name="first_name" class="form-control" id="username" placeholder="First name" value="<?php echo set_value('first_name', isset($user['first_name']) ? $user['first_name'] : '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="username" placeholder="Last name" value="<?php echo set_value('last_name', isset($user['last_name']) ? $user['last_name'] : '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Phone</label>
                        <input type="text" name="phone" class="form-control" id="username" placeholder="Phone" value="<?php echo set_value('phone', isset($user['phone']) ? $user['phone'] : '') ?>">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="Submit" class="btn btn-primary">Submit</button> 
                    <button type="button" class="btn btn-default" onclick="javascript:history.back()">Back</button><br />
                </div>
            <?php echo form_close();?>
	</div>



                     <div class="col-sm-12 col-lg-6" >
                     </div>

            </div>
    </div>
