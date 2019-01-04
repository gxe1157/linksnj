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

    /* check before we load auth module */
    if( $this->uri->segment(2) == 'email_response' )
                $this->email_response();

    if( $this->uri->segment(2) == 'cron_expired_emails' )
                $this->cron_expired_emails();


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

    $data['selected_status']  = is_numeric($this->uri->segment(3)) ? $this->uri->segment(3): '';

    $data['base_url'] = base_url();
    $data['columns'] = $this->model_name->get('id desc');
    $data['page_url'] = "manage";

    $this->cron_expired_emails(true);

    $this->load->module('templates');
    $this->templates->admin($data);        
}


function build_data( $user_id = null )
{

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_online_leads";    

    $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                              	'sb-admin/js/admin_js/site_loader_datatable',
                                'sb-admin/js/admin_js/site_online_leads',
                                'sb-admin/js/admin_js/format_flds'];    

    return $data;
}    

function create()
{
    $update_id = $this->uri->segment(3);
	$selected_status =$this->uri->segment(4); // view/from manage.php

    $cancel = $this->input->post('cancel', TRUE);
    if( $cancel == "member_manage" || $cancel == "manage_admin") {
    	$selected_status = $this->input->post('selected_status', TRUE); // from view/create.php
        redirect($this->main_controller.'/'.$cancel.'/'.$selected_status); 
    }

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
            $data['activation_code'] = $this->site_security->generate_random_string(10);

            // $data['opened'] -> 0 = new, 1 = read, 2 = assigned, 3 = expired, 4 = agent_working 
            switch ($data['opened']) {
                case "1":
                    $data['opened'] ='2'; // assigned
                    $add_tracking = true; // create new tracking if record is updated
                    break;

                case "2":
                    if( $this->model_name->check_activation_code($update_id) ) {
                        /* update tracking and send email to notify it was reassigned. */
                        $this->model_name->cancel_leads_email($data, $update_id);

                        /* New tracking details. */
                        $add_tracking = true; // create new tracking if record is updated
                    } else {
                        unset($_POST);
                        $this->set_flash_msg('Your request to re-assign agent can not completed at this time.', 'danger');

                        redirect( $this->main_controller.'/create/'.$update_id);
                    }    
                    break;

                case "3":
                    $data['opened'] ='2'; // assigned
                    $add_tracking = true; // create new tracking if record is updated
                    break;

                case "4":
                	quit('This is already marked as ok..... ');

                    break;
                default:
                	quit(99);
            }

            $save_data['activation_code'] = $data['activation_code'];                    
            $save_data['select_agent'] = $data['select_agent'];
            $save_data['opened'] = $data['opened'];
            $save_data['admin_id'] = $data['admin_id'];

            /* Update or Create New Record */
            list($update_id, $flash_message, $flash_type) = $this->model_name->create_update_data($update_id, $save_data, $mess_header);

            /* On success */
            if($flash_type == 'success' && $add_tracking == true ) {
                // insert appointment_tracking detail
                $data['track_id'] = $this->model_name->insert_tracking($update_id, $save_data['select_agent']);
                $this->model_name->newleads_email($data);
                sleep(1);
            }

            $this->set_flash_msg($flash_message, $flash_type);        

            redirect( $this->main_controller.'/create/'.$update_id);
        } // $this->form_validation
    }

    if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
        $fetch['columns'] = $this->fetch_data_from_db($update_id);
        /* check status - if email not read then mark as read */
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
	$data['selected_status'] =$this->uri->segment(4);

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;

    $data['action']   = $data['opened'] == '1' ? 'Assign Agent' : 'Change Assigment';
    if($data['opened'] == '4') {
        $data['action'] = "[]";
        $data['disable_submit'] = "disabled";
    } 

    $data['cancel']   = 'manage_admin';
    $data['page_url'] = "create";
    $data['update_id']= $update_id;

    $this->load->module('templates');
    $this->templates->admin($data);    
}

function email_response() {
    $id = $this->uri->segment(3); // 'appointment_tracking'
    $activation_code = $this->uri->segment(4); // appointment_request table

    /* get appoinment request details before we update */
    $details = $this->model_name->get_by_field_name('activation_code', $activation_code, null, 'appointment_request')->result_array();
    $rows_updated = $this->model_name->update_tracking($id, $activation_code);

    /* Update sales lead tracking */
    if($rows_updated>0){
        /* email to admin send */
        $this->model_name->accepted_email_lead($details[0]);
    } else {
        quit('The link to confirm sales lead.. failed Page');
    }

}

function cron_expired_emails($option=null)
{
    // https://linksnj.com/site_online_leads/cron_expired_emails
    $query = $this->model_name->check_assigned_time_elapsed();
  	$time_now = time();
  	$email_mess = '';
	$message = '';  	
	$list    = '';

	$x = 0;
    foreach ($query as $key => $value) {
    	$sent_date = $value->sent_date;

  		// (7 * 24 * 60 * 60); // 7 days; 24 hours; 60 mins; 60 secs
     	$time_diff = ($time_now + (7 * 24 * 60 * 60)) - $value->sent_date;
		$time_diff = ($time_now) - $value->sent_date;
		$time_passed = floor($time_diff / 86400);

		if( $time_passed > 1 ){
			$x++;
			// appointment_request.id as request_id,
			$request_id = $value->request_id;
			$request = [
				'activation_code' => null,
				'opened' => 3
			];	

			// appointment_tracking.id as tracking_id,
			$tracking_id = $value->tracking_id;
			$track_details = [
				'sent_to_opened' => time(),
				'status' => 3
			];

            $this->model_name->update_cron_expired_emails($request_id, $request, $tracking_id, $track_details);

			// send email to admin and selected agent
			$agent_name = $this->model_name->get_agent_name( $value->select_agent );
			$fullname   = $value->fullname;

			$list = $x." - ".$fullname.' assigned to Links agent '.$agent_name."<br/>";
		}
    }
  
    if($option) return; // if true return to site_online_leads/manage_admin   

    if( !empty($list) ){
        $message = '<b>The appoinment sales leads listed below have not been acknowledged and are expired. Please re-assign to another agent.</b><br /><br />';
        $message .= $list;
        $this->model_name->cron_expired_email($message);
    } else {
        $message = '<b>No activity to report for today.</b><br /><br />';
        $this->model_name->cron_expired_email($message);            
    }

    die('cron_expired_emails is done..... ');
}

function time_elapsed_A($secs)
{
	$ret = [];
    $bit = array(
	        'd' => $secs / 86400 % 7,
	        'h' => $secs / 3600 % 24,
	        'm' => $secs / 60 % 60
	        );
	        
	    foreach($bit as $k => $v)
	        if($v > 0) $ret[] = $v . $k;

	$number_days = floor($secs / 86400);
	$days = $number_days == 1 ? ' day' : ' days';  
	$response = $number_days == 0 ? join(' ', $ret) : $number_days.$days;

	return $response;
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
