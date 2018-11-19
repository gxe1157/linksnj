<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if( isset( $default['flash']) ) {
      echo $this->session->flashdata('item');
      unset($_SESSION['item']);
  }

  $data['message_hdr'] = "Customer Support";
  $data['update_id']   = $update_id;
  $data['error_mess']  = validation_errors("<p style='color: red;'>", "</p>");
  $this->load->view('enquiries/message_modal', $data);

  // Member Details Banner
    if( $mode == 'admin_member_profile' )
            $this->load->view( 'default_module/admin_banner');
  // Member Details Banner

?>

<style type="text/css">
  .urgent {
    color: red; 
  }
</style>

<h2 style="margin-top: -5px;"><small><?= $default['page_header'] ?></small></h2>
 <!-- Button trigger modal -->
 <button type="button"
         class="btn btn-primary tab-button"
         data-toggle="modal"
         data-target="#replyModal">
    Customer Support
 </button>

<!-- <a href="<?= base_url() ?>youraccount/welcome" >
   <button type="button" class="btn btn-default tab-button">Cancel</button>
</a>
 -->
<div class="row">   
  <div class="col-md-12">
        <table id="example" class="table table-striped table-bordered responsive"
                            cellspacing="0" width="100%">                          
            <thead>
                <tr>
                    <th style="width: 6%">&nbsp;</th>
                    <th style="width: 9%">Avatar</th>
                    <th style="width: 25%">Sent By</th>
                    <th style="width: 30%">Subject</th>                    
                    <th style="width: 15%">Status</th>                    
                    <th style="width: 10%">Priority</th>
                    <th style="width: 5%">Actions</th>
                </tr>
            </thead>   
            <tbody>
              <?php
              foreach($query->result() as $row) {
                  $view_url = base_url()."enquiries/view/".$row->id;
                  $user_data['fullname'] = $row->first_name.' '.$row->last_name;
                  $opened = $row->opened;
                  $urgent = $row->urgent;
                  $ranking = $row->ranking;

                  if ($opened==1) {
                    $icon = '<i class="fa fa-envelope-o fa-2x" aria-hidden="true"></i>';
                  } else {
                    $icon = '<i class="fa fa-envelope fa-2x" style="color: orange" aria-hidden="true"></i>';
                  }

                  $date_sent = convert_timestamp($row->date_created, 'info');

                  if ($row->sent_by==0) {
                    $sent_by = "Admin";
                  } else {
                    $sent_by = $user_data['fullname'];
                  }
              ?>
              <tr <?php if ($urgent==1) echo ' class="urgent"'; ?> >
                    <td><?= $icon ?></td>
                    <td>
                      <span><img src="http://placehold.it/50x50"></span>
                    </td>
                    <td>
                      <div style="font-size: 1.1em; font-weight: bold; color: #3B5998"><?= $sent_by ?></div>
                      <div style="margin-top: 8px; font-size: 1em; color: #999;">
                          Message: #KJJ-847-87242
                      </div>
                    </td>
                    <td>
                      <div style="font-size: 1.1em;"><?= $row->subject ?></div>
                      <div style="margin-top: 8px; font-size: 1em; color: #999;">
                        Sent: <?= $date_sent ?>
                      </div>

                    </td>
                    <td><div style="font-size: 1.1em;">Awaiting Reply</div></td>
                    <td><div style="font-size: 1.1em;">Medium</div></td>
                    <td>
                      <a class="btn btn-info" href="<?= $view_url ?>">
                         <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                      </a>
                    </td>
                </tr>
              <?php
              }
              ?>

            </tbody>
        </table>       
        <form>
            <input type="hidden" id="base_url" value="<?= base_url() ?>" >
        </form>
  </div>
</div><!--/row-->














