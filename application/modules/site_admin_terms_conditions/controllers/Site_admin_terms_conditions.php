<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_admin_terms_conditions extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_admin_terms_conditions';
public $main_controller = 'site_admin_terms_conditions';


public $column_rules = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();

function __construct() {
    parent::__construct();

    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal';

    $this->load->helper('site_admin_terms_conditions/form_flds_helper');
    $this->column_rules = get_fields();

    /* page settings */
    $update_id = $this->uri->segment(3);
    $this->default['page_title'] = "Manage Terms and Conditions";    
    $this->default['headline'] = !is_numeric($update_id) ? "Manage Terms and Conditions" : "Update Terms and Conditions";        
    $this->default['page_header'] = !is_numeric($update_id) ? "Add New Terms and Conditions" : "Update Terms and Conditions";

    $this->default['page_nav'] = "Terms and Conditions";         
    $this->default['add_button']  = "Add New Terms and Conditions";
    $this->default['flash'] = $this->session->flashdata('item');

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

function manage_admin()
{

    $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                                'sb-admin/js/admin_js/site_loader_datatable',
                                'sb-admin/js/admin_js/format_flds'];    

    $data['columns']  = $this->model_name->get('title'); // get form fields structure
    $data['default']  = $this->default;    
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->admin($data);    
}


function create()
{
     
    $update_id = $this->uri->segment(3);

    $cancel = $this->input->post('cancel', TRUE);
    if( $cancel == "member_manage" || $cancel == "manage_admin")
        redirect($this->main_controller.'/'.$cancel); 

    $submit = $this->input->post('submit', TRUE);
    if( $submit == "Submit" ) {
        // process changes
        $this->load->library('form_validation');
        $this->form_validation->set_rules( $this->column_rules );

        if($this->form_validation->run() == TRUE) {
            $mess_header = "Terms and Conditions ";
            $flash_type = null;            

            $data = $this->fetch_data_from_post();            
            $data['admin_id'] = $this->site_security->_user_logged_in();

            /* Update or Create New Record */
            list($update_id, $flash_message, $flash_type) = $this->model_name->create_update_data($update_id, $data, $mess_header);

            $this->set_flash_msg($flash_message, $flash_type);        

            redirect( $this->main_controller.'/create/'.$update_id);
        } // $this->form_validation

    }

    if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
        $fetch['columns'] = $this->fetch_data_from_db($update_id);
    } else {
        $fetch['columns'] = $this->fetch_data_from_post();
    }

    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;

    $data['custom_jscript'] = [ 'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];    

    $data['action'] = is_numeric($update_id) ? 'Update Record' : 'Submit';
    $data['cancel']     = 'manage_admin';
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
    $data['title'] = $row_data['title'];            
    $rows_deleted = $this->model_name->delete( $update_id );

    $flash_message = $rows_deleted > 0 ? 'The Terms and Conditions titled "'.$data['title'].'" was successfully deleted. ' : 'Delete Terms and Conditions has <b>failed</b>. ';

    if($rows_deleted < 1 ) $flash_type ="danger";
    $this->set_flash_msg($flash_message, $flash_type);      

    redirect( $this->main_controller.'/manage_admin');
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
