<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_ajax_upload extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_upload_categories';
public $store_controller = 'site_ajax_upload';

public $column_rules = array(
    array('field' => '---', 'label' => '---', 'rules' => '---')
);

// use like this.. in_array($key, $columns_not_allowed ) === false )
public  $columns_not_allowed = array( 'create_date' );

public $upload_img_base ='';
public $admin_id = 0;


function __construct() {
    parent::__construct();
    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

    $this->upload_img_base ='./upload/';
    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal'    
}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   =================================================== */

function ajax_remove_one()
{
    sleep(1);
    $img_id  = $this->input->post('img_id', TRUE);

    /* full upload path */
    $upload_path = $this->_build_upload_folder($img_id);
    $query = $this->get_where($img_id);
    $result_set = $query->result();
    $file_name = $result_set[0]->image;
    $file_location  = $upload_path.$file_name;

    $data = $this->_delete_file($file_location);
    $img_parse =  explode('_', $file_name);
    $data['remove_name'] = $img_parse[1];
    $data['default'] = $this->default;

    if($data['success'] == 1)
        $this->model_name->_delete($img_id);

    echo json_encode($data);
}

function ajax_upload_one()
{
    sleep(1);

    $user_id  = $this->input->post('member_id', TRUE);
    $position = $this->input->post('position', TRUE);
    $parent_cat_name = $this->input->post('parent_cat', TRUE);
    $parent_cat_array= explode('_', $parent_cat_name);

    /* set image as part number and add ext name */
    $uploaded_file = explode('.', $_FILES['file']['name'][$position]);
    $imagename = $user_id.'_'.$uploaded_file[0];
    $imagename .= '.'.$uploaded_file[1];

    /* full upload path */
    $upload_path = $this->_build_upload_folder($user_id);

    /* check mysql for active_image */
    $is_uploaded = $this->_is_already_uploaded($user_id, $imagename, $upload_path);

    if( $is_uploaded == false ){
        $this->load->library('upload', $config);

        $vector = $_FILES['file'];
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;

        $_FILES["file"]["name"] = $result[$position]["name"];
        $_FILES["file"]["type"] = $result[$position]["type"];
        $_FILES["file"]["tmp_name"] = $result[$position]["tmp_name"];
        $_FILES["file"]["error"] = $result[$position]["error"];
        $_FILES["file"]["size"] = $result[$position]["size"];

        $config["upload_path"]   = $upload_path;
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size']      = '2048';
        $config['overwrite']     = true;
        $config['file_name']     = $imagename; // set the name here

        $this->upload->initialize($config);

        if( $this->upload->do_upload('file') ) {
          $data = $this->upload->data();
          $table_data = [
             'userid' => $user_id,
             'parent_cat' => null,
             'image' => $data['file_name'],
             'orig_name' => $data['client_name'],
             'path' => $data['full_path'],
             'size' => $data['file_size'],
             'width_height' => $data['image_size_str'],
             'create_date' => time(),
             'modified_date' => time(),
             'admin_id' => $this->admin_id
          ];

          $data['image_date'] = convert_timestamp( time(), 'datepicker_us');
          $data['success'] = 1;
          $data['error_mess'] = '';
          $data['update_rec'] = $this->_update_img_data($user_id, $parent_cat_array[1], $table_data);
        } else {
          // display errors
          $return_message = "<p>The filetype/size you are attempting to upload is not allowed. The max-size for files is ".$config['max_size']." kb and accepted file formats are ".$config['allowed_types'].".</p>";
          $data['success'] = 0;
          //$data['error_mess'] = $return_message;
          $data['error_mess'] = $this->upload->data();

        }

    } else {
          $return_message = "<p>File is already uploaded.";
          $data['success'] = 0;
          $data['error_mess'] = $return_message;
    }

    $data['is_uploaded'] = $is_uploaded;
    $data['upload_path'] = $upload_path;    // use to debug
    echo json_encode($data);
    return;
}

function _update_img_data($user_id, $parent_cat_name, $table_data)
{
    /* Update database */
    $update_rec = $this->model_name->update_data($user_id, $parent_cat_name, $table_data);
    return $update_rec;
}

function _is_already_uploaded($user_id, $imagename, $img_path)
{
    $mysql_query = "SELECT * FROM `users_upload` WHERE `image` = '".$imagename."'";
    $result_set  = $this->model_name->_custom_query($mysql_query)->result();

    $is_found = count($result_set)>0 ? true : false;
    if( $is_found == false){
        /* check if image is on drive and remove if found */
        $file_location  = $img_path.$imagename;
        $this->_delete_file($file_location);
    }
    return $is_found;
}

function _delete_file($file_location)
{
    /* delete image file */
    $data['success'] = 1;
    $data['error_mess'] = '';

    if( file_exists( $file_location ) && !is_dir($file_location) ){
        if (!unlink($file_location)) {
            // send to log and email......
            $return_message = 'Error: File did not delete. Nofity Developer. ';
            $data['success'] = 0;
            $data['error_mess'] = $return_message;
        }
    }
    return $data;

}


function _build_upload_folder($user_id)
{
    $prd_folder = ''; //$user_id;
    $upload_path = $this->upload_img_base.$prd_folder;

    return $upload_path;
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
