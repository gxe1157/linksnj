<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if( isset( $default['flash']) ) {
    echo $this->session->flashdata('item');
    unset($_SESSION['item']);
  }
  $redirect_url = $group_no == 'Clients' ? 'site_customers': 'site_users';
?>



<!-- <h1><?php echo lang('index_heading');?></h1> -->
<h2 style="margin-top: -5px;"><small><?= $default['page_nav'] ?></small></h2>
<p><?php echo lang('index_subheading');?></p>

<table id="users" class="table table-condensed table-bordered table-striped table-hover" width="100%">
  <thead>
    <tr>
      <th><?php echo lang('index_fname_th');?></th>
      <th><?php echo lang('index_lname_th');?></th>
      <th><?php echo lang('index_email_th');?></th>
      <th><?php echo lang('index_groups_th');?></th>
      <th style="width: 8%;"><?php echo lang('index_status_th');?></th>
      <th style="width: 12%;"><?php echo lang('index_action_th');?></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($users as $user):?>
    <tr>
      <td><?php echo $user->first_name;?></td>
      <td><?php echo $user->last_name;?></td>
      <td><?php echo $user->email;?></td>
      <td>
        <?php foreach ($user->groups as $group):?>
        <?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
        <?php endforeach?>
      </td>
      <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), array( 'class '=> 'btn btn-sm btn-success') ) : anchor("auth/activate/". $user->id, lang('index_inactive_link'), array( 'class '=> 'btn btn-sm btn-danger'));?></td>
      <td>
        <?php echo anchor("auth/edit_user/".$user->id, 'Edit',
         array('class '=> 'btn btn-sm btn-info' )) ;?>
        <?php echo anchor( $redirect_url."/create/".$user->id, 'Profile',
         array('class '=> 'btn btn-sm btn-info' ) );?>      
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  
</table>

<p><?php echo anchor('auth/create_user', lang('index_create_user_link'),
      array( 'class '=> 'btn btn-info'))?>
  <?php echo anchor('auth/create_group', lang('index_create_group_link'),
      array( 'class '=> 'btn btn-warning') )?>
</p>