<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_admin_emails extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_admin_emails';
public $main_controller = 'site_admin_emails';


public $column_rules = array(
    array('field' => 'type', 'label' => 'Email Type', 'rules' => 'required'),
    array('field' => 'admin_email', 'label' => 'Admin Email', 'rules' => 'required|valid_email'),
    array('field' => 'from', 'label' => 'From', 'rules' => 'required|valid_email'),
    array('field' => 'subject', 'label' => 'Subject Line', 'rules' => 'required'),
    array('field' => 'body', 'label' => 'Body', 'rules' => 'required'),    
);

// use like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();

function __construct() {
    parent::__construct();

    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal';

    /* Manage panel */
    $update_id = $this->uri->segment(3);
    $this->default['headline']     = !is_numeric($update_id) ? "Manage Emails" : "Update Email Details";        
    $this->default['add_button']   = "Add New Email";
    $this->default['flash'] = $this->session->flashdata('item');
}



/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

function manage()
{
    
    $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                                'sb-admin/js/admin_js/site_loader_datatable',
                                'sb-admin/js/admin_js/format_flds'];    

    $data['columns']   = $this->model_name->get('type'); // get form fields structure
    $data['default']   = $this->default;    
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->admin($data);    
}


function create()
{
     
    $update_id = $this->uri->segment(3);
    $submit = $this->input->post('submit', TRUE);
    if( $submit == "Cancel" ) {
        redirect( $this->main_controller.'/manage');
    } 

    if( $submit == "Submit" ) {
        // process changes
        $this->load->library('form_validation');
        $this->form_validation->set_rules( $this->column_rules );

        if($this->form_validation->run() == TRUE) {
            $mess_header = "Email ";
            $flash_type = null;            

            $data = $this->fetch_data_from_post();            
            $data['admin_id'] = $this->site_security->_user_logged_in();

            /* Update or Create New Record */
            list($update_id, $flash_message, $flash_type) = $this->model_name->create_update_data($update_id, $data, $mess_header);

            $this->set_flash_msg($flash_message, $flash_type);        

            redirect( $this->main_controller.'/create/'.$update_id);
        }
    }

    if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
        $data['columns'] = $this->fetch_data_from_db($update_id);
    } else {
        $data['columns'] = $this->fetch_data_from_post();
    }

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;
    $data['labels'] = $this->_get_column_names('label');
    $data['custom_jscript'] = [ 'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];    

    $data['page_url'] = "create";
    $data['update_id'] = $update_id;

    $this->load->module('templates');
    $this->templates->admin($data);    

}

function delete( $update_id )
{
    $this->numeric_check($update_id);    

    /* get title from mysql */
    $row_data = $this->fetch_data_from_db($update_id);
    $data['type'] = $row_data['type'];            
    $rows_deleted = $this->model_name->delete( $update_id );

    $flash_message = $rows_deleted > 0 ? 'Email "'.$data['type'].'" was successfully deleted. ' : "Email selected <b>failed</b> to be deleted";

    if($rows_deleted < 1 ) $flash_type ="danger";
    $this->set_flash_msg($flash_message, $flash_type);      

    redirect( $this->main_controller.'/manage');
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
