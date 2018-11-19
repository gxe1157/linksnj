
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if( isset( $default['flash']) ) {
    echo $this->session->flashdata('item');
    unset($_SESSION['item']);
  }
  $create_account_url = base_url()."store_accounts/create";
?>

<h2 style="margin-top: -5px;"><small><?= $default['page_title'] ?></small></h2>
<p style="margin-top: 30px,">
  <a href="<?= base_url().$this->uri->segment(1) ?>/create" >
    <button type="button" class="btn btn-primary"><?= $default['add_button'] ?></button></a>
</p>

<div class="row">   
  <div class="col-md-12">
      <table id="example"  class="table table-striped table-bordered">

                          <thead>
                              <tr>
                                  <th>Username</th>
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Company</th>
                                  <th>Date Created</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>   
                          <tbody>
                            <?php
                            $this->load->module('timedate');
                            foreach($query->result() as $row) { 
                                $edit_url = base_url().$this->uri->segment(1)."/create/".$row->id;
                                $date_created = convert_timestamp($row->create_date, 'datepicker_us');

                            ?>
                            <tr>
                                <td><?= $row->username ?></td>
                                <td><?= $row->firstname ?></td>
                                <td class="center"><?= $row->lastname ?></td>
                                <td class="center"><?= $row->company ?></td>
                                <td class="center">
                                    <?= $date_created ?>
                                </td>
                                <td class="center">
                                    <a class="btn btn-info btn-sm" style="font-size: 12px; padding: 0px 5px 0px 0px;" href="<?= $edit_url ?>">
                  <i class="fa fa-pencil fa-fw"></i> Edit
                </a>
                                  
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            
                          </tbody>
    </table>            
  </div>
</div><!--/row-->