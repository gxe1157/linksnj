<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_online_leads extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_online_leads';
public $main_controller = 'site_online_leads';

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

    /* Load field data */    
    $this->load->helper('site_online_leads/form_flds_helper');    
    $this->column_rules = get_fields();

    /* Get user data selected from manage_admin/manage */
    $update_id = $this->uri->segment(3);

    /* Set page defaults */
    $this->default['page_nav'] = "Manage Online Leads";           
    $this->default['page_title'] = "Manage Online Leads";    

    $this->default['flash'] = $this->session->flashdata('item');

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */


function manage_admin()
{

    $data = $this->build_data();

    $data['base_url'] = base_url();
    $data['columns'] = $this->model_name->get();
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->admin($data);        
}


function build_data( $user_id = null )
{

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_online_leads";    
    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/admin_js/site_online_leads',
                                'sb-admin/js/admin_js/model_js' ];

    return $data;
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
            $mess_header = "Online Leads ";
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
        /* check status - if not read then mark as read */
        $fetch['columns']['opened'] = $this->model_name->check_status($fetch['columns'], $update_id);
    } else {
        $fetch['columns'] = $this->fetch_data_from_post();
    }

    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);

    /* Get Agents names as options */
    $data['select_options'] = $this->model_name->get_agents();

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;

    $data['custom_jscript'] = [ 'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];    

    $data['action'] = is_numeric($update_id) ? 'Assign Agent' : 'Submit';
    $data['cancel']     = 'manage_admin';
    $data['page_url'] = "create";
    $data['update_id'] = $update_id;

    $this->load->module('templates');
    $this->templates->admin($data);    

}



/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
