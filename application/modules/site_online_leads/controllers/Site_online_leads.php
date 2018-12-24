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

    /* lead reply */
    if( $this->uri->segment(2) == 'email_response' )
                $this->email_response();

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

    /* Get Agents names as options */
    $data['select_options'] = $this->model_name->get_agents();

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
            $add_tracking = false;

            $data = $this->fetch_data_from_post();            
            $data['admin_id'] = $this->site_security->_user_logged_in();

            switch ($data['opened']) {
                case "1":
                    $data['opened'] ='2'; // assigned
                    $add_tracking = true; // create new tracking if record is updated
                    $data['activation_code'] = $this->site_security->generate_random_string(10);
                    $save_data['activation_code'] = $data['activation_code'];                    
                    break;

                case "2":
                    if( $this->model_name->check_activation_code($update_id) ) {
                        /* send email to notify it was reassigned. */
                        $this->model_name->cancel_leads_email($data);

                        $add_tracking = true; // create new tracking if record is updated
                        $data['activation_code'] = $this->site_security->generate_random_string(10);
                        $save_data['activation_code'] = $data['activation_code'];       
                    } else {
                        // quit('Can not change agent at this time..... ');
                        unset($_POST);
                        $this->set_flash_msg('Your request to re-assign agent can not completed at this time.', 'danger');        

                        redirect( $this->main_controller.'/create/'.$update_id);
                    }    
                    break;

                case "3":
                    quit(33);
                    // ddf('Declined lead.......', 1);
                    // change opened to 2
                    // send email to notify assigned agent it was canceled
                    //   
                    break;

                default:
                quit(99);
            }

            $save_data['select_agent'] = $data['select_agent'];
            $save_data['opened'] = $data['opened'];
            $save_data['admin_id'] = $data['admin_id'];

            /* Update or Create New Record */
            list($update_id, $flash_message, $flash_type) = $this->model_name->create_update_data($update_id, $save_data, $mess_header);

            /* On success */
            if($flash_type == 'success' && $add_tracking == true ) {
                // insert appointment_tracking detail
                $data['track_id'] = $this->model_name->insert_tracking($update_id, $save_data['select_agent']);
                // send email 
                $this->model_name->newleads_email($data);
            }

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
    $data['opened'] = $data['columns']['7']['value'];

    /* Get lead_details */
    $data['lead_details'] = $this->model_name->get_lead_details($update_id);

    /* Update field for view */
    $availability = $data['columns']['5']['value'];
    $data['columns']['5']['value'] = $this->model_name->get_availability($availability);

    $links_agent = $data['columns']['4']['value'];
    $data['columns']['4']['value'] = $links_agent == 'true' ? 'Yes' : 'No';

    /* Get Agents names as options */
    $data['select_options'] = $this->model_name->get_agents();

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;

    $data['action']   = $data['opened'] == '1' ? 'Assign Agent' : 'Change Assigment';
    $data['cancel']   = 'manage_admin';
    $data['page_url'] = "create";
    $data['update_id']= $update_id;

    $this->load->module('templates');
    $this->templates->admin($data);    

}

function email_response() {
    $id = $this->uri->segment(3); // action
    $acitvation_code = $this->uri->segment(4); // action

    /* get by id the agent_id */


    /* Update sales lead tracking */
    $rows_updated = $this->model_name->update_tracking($id, $acitvation_code);
    
    if($rows_updated>0){
        quit('The link to confirm sales lead.. Success Page');
    } else {
        quit('The link to confirm sales lead.. failed Page');
    }

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
