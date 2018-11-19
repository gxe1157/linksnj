<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Webpages extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'mdl_webpages';
public $store_controller = 'webpages';

public $column_rules = array(
    array('field' => 'page_url', 'label' => 'Page URL', 'rules' => ''),
    array('field' => 'page_title', 'label' => 'Page Title', 'rules' => 'required|max_length[250]|callback_item_check'),
    array('field' => 'page_keywords', 'label' => 'Page Keywords', 'rules' => ''),
    array('field' => 'page_description', 'label' => 'Page Description', 'rules' => ''),
    array('field' => 'status', 'label' => 'Status', 'rules' => 'required'), 
    array('field' => 'left_side_nav', 'label' => 'Left Side Nav Menu', 'rules' => ''),         
    array('field' => 'image_repro', 'label' => 'Image Repository', 'rules' => ''),                
    array('field' => 'page_content', 'label' => 'Page Content', 'rules' => '')
);

//// use like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array();
public $default = array();

function __construct() {
    parent::__construct();
    /* Manage panel */
    $update_id = $this->uri->segment(3);
    $this->default['headline'] = !is_numeric($update_id) ?
           "Manage Webpages" : "Update Webpage Details";        

    $this->default['flash'] = $this->session->flashdata('item');       

}

/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

  function manage()
  {
      

      $data['status_mess'] = ['Active', 'Inactive', 'Under Construction'];
      $this->default['add_button']   = "Add New Webpage";      
      $data['redirect_url'] = base_url().$this->uri->segment(1)."/create";
      $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                                  'public/js/site_loader_datatable',
                                  'public/js/format_flds'];    

      $data['columns']  = $this->model_name->get('page_url'); // get data ordered by .. 
      $data['default']  = $this->default;    
      $data['page_url'] = "manage";

      $this->load->module('templates');
      $this->templates->admin($data);                       
  }

  function create()
  {

      $update_id = $this->uri->segment(3);
      $submit = $this->input->post('submit', TRUE);

      if( $submit == "Cancel" ) {
          redirect($this->store_controller.'/manage');
      }

      if( $submit == "Submit" ) {
          // process changes
          $this->load->library('form_validation');
          $this->form_validation->set_rules( $this->column_rules );

          if($this->form_validation->run() == TRUE) {
              $data = $this->fetch_data_from_post();
              // make search friendly url
              $data['page_url'] = url_title( $data['page_title'] );

              // Do not populate page_url for Home and contact us pages
              if( $update_id == 1 || $update_id == 2 ){
                  unset( $data['page_url'] );
              }

              if(is_numeric($update_id)){
                  //update the page details
                  $this->_update($update_id, $data);
                  $this->_set_flash_msg("The page details were sucessfully updated.");
              } else {
                  //insert a new page
                  $update_id = $this->model_name->insert($data);
                  // $flash_msg
                  $this->_set_flash_msg("The page was sucessfully created.");
              }
              redirect($this->store_controller.'/create/'.$update_id);
          }
      }

      if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
          $data['columns'] = $this->fetch_data_from_db($update_id);
      } else {
          $data['columns'] = $this->fetch_data_from_post();
      }

      $data['button_options'] = "Update Customer Details";
      $data['headtag']   = "Webpages listing";

      $data['default'] = $this->default;  
      $data['columns_not_allowed'] = $this->columns_not_allowed;
      $data['labels'] = $this->get_column_names('label');
      $data['custom_jscript'] = [ 'sb-admin/js/jquery.cleditor.min',
                                  'public/js/site_loader_cleditor',
                                  'public/js/format_flds'];    

      $data['page_url'] = "create";
      $data['update_id'] = $update_id;

      $this->load->module('templates');
      $this->templates->admin($data);    
          
  }

  function view( $update_id )
  {
      $this->numeric_check( $update_id );
      // fetch page details for pubic page
      $data['columns'] = $this->fetch_data_from_db($update_id);
      
      $data['headline']  = "";
      $data['view_module'] = "webpages";
      $data['page_url'] = "view";
      $data['update_id'] = $update_id;

      $this->_render_view('public_bootstrap', $data);
  }


  function delete( $update_id )
  {
      $this->numeric_check($update_id);
      

      $submit = $this->input->post('submit', TRUE);
      if( $submit =="Cancel" ){
          redirect($this->store_controller.'/create/'.$update_id);
      } elseif( $submit=="Yes - Delete Page" ){
          /* get page title from webpages table */
          $row_data =
                $this->fetch_data_from_db($update_id);
          $data['page_title'] = $row_data['page_title'];

          /* delete item */
          $this->model_name->delete( $update_id );          
          $this->_set_flash_msg("The page ".$data['page_title'].", was sucessfully deleted");

          redirect($this->store_controller.'/manage');
      }

  }


  function deleteconf( $update_id )
  {
      $this->numeric_check($update_id);
      
      if( $update_id < 3 ) 
          redirect($this->store_controller.'/manage');

      /* get page title and small img from webpages table */
      $row_data = $this->fetch_data_from_db($update_id);
      $data['page_title'] = $row_data['page_title'];

      $data['headline']  = "Delete page";
      $data['page_url'] = "deleteconf";
      $data['update_id']  = $update_id;

      $this->_render_view('admin', $data);
  }




/* ===============================================
    Call backs go here...
  =============================================== */


  function item_check($str) {
      $item_url = url_title($str);
      $mysql_query = "select * from webpages where page_title='$str' and page_url='$item_url'";

      $update_id = $this->uri->segment(3);
      if(is_numeric($update_id)) {
          // this is an update
          $mysql_query .= " and id!='$update_id'";
      }

      $query = $this->model_name->custom_query($mysql_query);
      $num_rows = $query->num_rows();

      if( $num_rows > 0 ){
          $this->form_validation->set_message('item_check', 'The Page Title you selected is not available.');
          return FALSE;
      } else {
          return TRUE;
      }

  }




/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
