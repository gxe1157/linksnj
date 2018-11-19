<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_users extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_upload_categories';
public $main_controller = 'site_users';

public $column_pword_rules  = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();

function __construct() {
    parent::__construct();
    if( $this->default['is_admin'] != 1 )
    {
        //checkField('You are not an ADMIN! This area is restricted to admin only.', 1);
    }
    $this->default['page_nav'] = "Managa User Upload";
    $this->default['flash']    = $this->session->flashdata('item');
    $this->default['admin_mode'] = $this->session->admin_mode; 

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function member_upload()
{
    $update_id  = $this->site_security->_make_sure_logged_in();
    $data = $this->build_data( $update_id );
    // checkArray($data[view_module],0);

    $data['menu_level'] = 1;
    $data['image_repro'] = '';
    $data['left_side_nav'] = true;
    $data['nav_module']= 'youraccount/';
    $data['title'] = "Upload Image using Ajax JQuery in CodeIgniter";
    $data['page_title'] = 'Upload Files';
    // $data['default'] = $this->default;    

    $this->load->module('templates');
    $this->templates->public_main($data);
}


function manage_uploads()
{
    $update_id = $this->uri->segment(3);
    $data = $this->build_data( $update_id );
    // checkArray($data,0);
    $this->load->module('templates');
    $this->templates->admin($data);
}

function build_data( $update_id )
{
    list( $data['status'], $data['user_avatar'],
          $data['member_id'], $data['fullname'] ) = get_login_info($update_id);

    $data['custom_jscript'] = [
          'public/js/member-portal',
          'public/js/upload-image',
          'public/js/model_js'
           ];

    list( $image_list, $users_images, $missing_uploads ) = $this->_get_image_info($update_id);

    $data['alert_mess'] =
         $this->set_message( $missing_uploads, $this->default['is_deleted'], $data['status']);

    $data['show_buttons'] = $default['is_deleted'] ? false : true;
    $data['image_list'] = $image_list;
    $data['users_images'] = $users_images;
    $data['userid'] = $update_id;
    $data['default']  = $this->default;
    $data['base_url'] = base_url();
    
    $data['view_module'] = 'site_upload';
    $data['page_url'] = "manage_uploads";

    return $data;
}

function set_message( $missing_uploads, $is_deleted, $status)
{
      $set_mess ='';

      if( $is_deleted ){
          $set_mess = '<div class="col-md-12 alert alert-danger">
                  <strong>Alert!</strong> This user account has been Deleted.
              </div>';
      } else if( $status == 2 ) {
          $set_mess = '<div class="col-md-12 alert alert-warning">
                  <strong>Alert!</strong> This user account has been Suspened.
              </div>';
      } else if( $missing_uploads>0  ) {
          $set_mess = '<div class="col-md-12 alert alert-danger">
                  <strong>Alert!</strong> There are still some required documents that need to be uploaded.
              </div>';
      }
      return $set_mess;

}

function _get_image_info($userid)
{
    /* Check userid account to verify passcode here */
    $image_list = array();
    $users_images = array();

    /* Get image categories
       parent_cat_id = 1 is Site User Required Documents  */
    $query = $this->model_name->get_view_data_custom('parent_cat_id', 1,'site_upload_categories', 'cat_title');
    foreach($query->result() as $row){
        $image_list[$row->id] = $row->cat_title;
    }
    /* echo "image_list: ".count($image_list); */
    if( count($image_list) > 0 )  {
      /* assign images to categories */
      $query = $this->model_name->get_view_data_custom('userid', $userid,'users_upload', null);
      foreach($query->result() as $row){
          $role = $image_list[$row->parent_cat];
          $img_uploaded = explode("_", $row->image);
          /* minimize image name conflicts by verifing userid attached to image name.*/
          if( $userid != $img_uploaded[0] ){
              die('.......... ERROR .............. prg: users_upload | '.$row->image);
              $users_images[ $role ] = array( $row->id, '');
          } else {
              $users_images[ $role ] = array( $row->id, $img_uploaded[1], $row->image,
                    $row->create_date, $row->path );
          }
      }
    }


    $missing_uploads = count($image_list) - count($users_images);

    return array($image_list, $users_images, $missing_uploads);
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
