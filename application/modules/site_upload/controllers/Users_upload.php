<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Users_upload extends MY_Controller
{

/* model name goes here */
var $mdl_name = 'Mdl_upload_categories';
var $store_controller = 'users_upload';

var $column_rules = array(
    array('field' => '---', 'label' => '---', 'rules' => '---')
);

//   Use like this.. in_array($key, $columns_not_allowed ) === false )
var  $columns_not_allowed = array( 'create_date' );

function __construct() {
    parent::__construct();

    // checkArray($this->default,1);
}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   =================================================== */

function ajax_remove_avatar()
{
    // $this->_security_check();
    $userid = $this->input->post('update_id', TRUE);

    $imagename = 'annon_user.png';
    $this->_update_avatar_data($imagename, $userid);

    $data['file_name'] = $imagename;
    echo json_encode($data);
}

function ajax_upload_one()
{
    // $this->_security_check();
    sleep(1);
    $userid = $this->input->post('update_id', TRUE);

    $config["upload_path"]   = './upload/';
    $config['allowed_types'] = 'jpeg|jpg|png|gif';
    $config['max_size']      = '2048'; // 2 MB

    $this->load->library('upload', $config);
    $imagename = $userid.'_avatar_'.$_FILES['file']['name'];

    $config['file_name'] = $imagename; // set the name here

    $this->upload->initialize($config);

    if($this->upload->do_upload('file')) {
       $data = $this->upload->data();
       $this->_update_avatar_data(str_replace(' ', '_', $imagename), $userid);
       $data['Success'] = 99;
    } else {
      // display errors
      $data['Success'] = 0;
      $data['file_info'] = $this->upload->data();
      $data['error_mess'] = "<p>The filetype/size you are attempting to upload is not allowed. The max-size for files is ".$config['max_size']." kb and accepted file formats are ".$config['allowed_types'].".</p>";

    }
    echo json_encode($data);
}

function _update_avatar_data($imagename, $userid)
{
    /* get image name on file */
    $default_avatar = 'annon_user.png';
    $mysql_query    = "SELECT avatar_name FROM `users_data` WHERE `id` =".$userid;
    $result_set     = $this->model_name->custom_query($mysql_query)->result();
    $avatar_on_file = $result_set[0]->avatar_name;

    if( $avatar_on_file != $default_avatar  &&  $avatar_on_file !='' ){
        $file_location  = './upload/'.$avatar_on_file;
        if( file_exists( $file_location ) )
            unlink($file_location);
    }

    /* Update database */
    $mysql_query = "UPDATE `users_data` SET `avatar_name` = '".$imagename."' WHERE `users_data`.`id` = ".$userid;
    $this->model_name->custom_query($mysql_query);
}




/* ===============================================
    Call backs go here...
  =============================================== */


/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
