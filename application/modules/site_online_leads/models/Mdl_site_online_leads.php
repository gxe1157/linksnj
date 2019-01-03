<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_site_online_leads extends MY_Model
{

public $email_admin = [
    'admin' =>'admin@linksnj.com',
    'info' => 'info@linksnj.com',
    'test' => 'info@mailers.com'  
];


function __construct( ) {
    parent::__construct();

}

function get_table() {
	// table name goes here	
    $table = "appointment_request";
    return $table;
}


/* ===================================================
    Add custom model functions here
   =================================================== */

function check_activation_code($update_id) {
    $query = $this->model_name->get_where($update_id)->row();
    $results = $query->activation_code;

    /* check if a new agent was selected */
    $active_agent = $_POST['select_agent'];
    $new_agent = $query->select_agent;      

    $results = ($active_agent == $new_agent) ? false : $results;
    return $results;
} 

function cancel_leads_email($data, $update_id) {
    /* Get lead_details from appointment_tracking table */
    $lead_details = $this->model_name->get_lead_details($update_id)->result();
    $last_row = array_pop($lead_details); // get last row
    $id = $last_row->id;
    unset($data['select_agent']);

    /* Update appointment_tracking */
    $save_tracking['status'] = 2; // 0 ='Pending', 1 = 'Accepted', 2 = 'Re-assigned';     
    $save_tracking['sent_to_opened'] = time();    
    $this->model_name->update($id, $save_tracking, 'appointment_tracking');

    $this->load->library('MY_Email_helpers');

    $agent_id   = $data['select_agent'];
    $email_to   = $this->email_admin['test']; //$this->model_name->get_agent_email($agent_id); 
    $email_from = $this->email_admin['admin'];
    $subject    = "Sales Lead Canceled";

    $compose_message .= "<br/><b/>A sales lead for ".$data['fullname']." which was recently sent to you has been re-assigned.</b><br/><br/> ";
    $compose_message .= $this->model_name->get_details($data);
    $compose_message .= "<br/><br/> ~Site Admin";    

    $data['compose_message'] = $compose_message;
    $message = $this->load->view('emails/email', $data, TRUE );

    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $message);
}

function newleads_email($data) {
    $this->load->library('MY_Email_helpers');

    $agent_id   = $data['select_agent'];
    $email_to   = $this->email_admin['test']; //$this->model_name->get_agent_email($agent_id);
    $email_from = $this->email_admin['admin'];
    $subject    = "A New Sales Lead";

    // $compose_message = "Time Stamp : ".convert_timestamp( time(), 'full')."<br/><br/><br/>"; 

    $compose_message .= $this->model_name->get_details($data);
    $compose_message .= "<br/><br/>Please click on link below to accept this lead.";    
    $compose_message .= "<br/>".anchor('site_online_leads/email_response/'. $data['track_id'].'/'.$data['activation_code'], 'Sales Lead Accepted');    
    $compose_message .= "<br/><br/> ~Site Admin";    

    $data['compose_message'] = $compose_message;
    $message = $this->load->view('emails/email', $data, TRUE );

    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $message);
}

function accepted_email_lead($data) {
    $this->load->library('MY_Email_helpers');
    $email_to   = $this->email_admin['test'];  //$this->email_from['admin'];
    $email_from = $this->model_name->get_agent_email($data['select_agent']);
    $subject    = "Sales Lead Accepted";

    // $compose_message = "Time Stamp : ".convert_timestamp( time(), 'full')."<br/><br/>"; 
    $compose_message .= "<b>The sales lead appointment for ".$data['fullname']." has been acknowledged.</b><br/><br/>";
    $compose_message .= $this->model_name->get_details($data);
    $compose_message .= "<br/><br/> ~Site Admin";    

    $data['compose_message'] = $compose_message;
    $message = $this->load->view('emails/email', $data, TRUE );

    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $message);
}

function cron_expired_email($compose_message) {
    $this->load->library('MY_Email_helpers');
    $email_to   = $this->email_admin['test'];  //$this->email_from['admin'];
    $email_from = $this->email_admin['test'];
    $subject    = "Expired Sales Lead report";

    $compose_message .= "<br/><br/> ~Site Admin";    

    $data['compose_message'] = $compose_message;
    $message = $this->load->view('emails/email', $data, TRUE );
    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $message);
}

function get_details(& $data)
{
    $availability = $data['availability'];

    $details['Appoinment Date'] = $data['appmnt_date'];
    $details['Full Name'] = $data['fullname']; 
    $details['Phone'] = $data['phone']; 
    $details['message']= $data['message'];
    $details['Links Agent'] = $data['links_agent'];
    $details['Availability'] = is_numeric($availability) ? $this->model_name->get_availability($availability) : $availability;
    if( is_numeric($data['select_agent']) )
         $details['Agent Name'] = $this->get_agent_name($data['select_agent']);

    foreach ($details as $key => $value) {
      $message_details .= "<span style='width: 50px;'>".ucfirst($key).": </span>".$value." <br/>";
    } 

    return $message_details;
}

function get_agent_name($agent_id)
{
    $results = $this->model_name->get_where($agent_id, 'users')->row();
    $fullname= $results->first_name.' '.$results->last_name;
    return $fullname;
}

function get_agent_email($agent_id)
{
    $results = $this->model_name->get_where($agent_id, 'users')->row();
    return $results->email;
}

function update_tracking($id, $activation_code)
{
    /* first update appoinment_request then update appoinment_tracking */
    $data_table = 'appointment_request';
    $col  = 'activation_code';
      
    $details = [
        'activation_code' => null,
        'opened' => 4
    ];

    $rows_updated = $this->model_name->update_byCol($col, $activation_code, $details, $data_table);

    if( $rows_updated > 0) {
        unset($details);
        $data_table = 'appointment_tracking';
        $details = [
            'sent_to_opened' => time(),
            'status' => 0
        ];
                                            
        $rows_updated = $this->model_name->update($id, $details, $data_table);
    }

    return $rows_updated;

}

function check_assigned_time_elapsed()
{
    $this->db->select('appointment_request.id as request_id,
                       appointment_request.activation_code,
                       appointment_request.links_agent,
                       appointment_request.select_agent,
                       appointment_request.opened,
                       appointment_request.fullname,                       
                       appointment_tracking.id as tracking_id,
                       appointment_tracking.appmnt_id,
                       appointment_tracking.sent_to,
                       appointment_tracking.sent_from,
                       appointment_tracking.sent_date,
                       appointment_tracking.sent_to_opened,
                       appointment_tracking.status');

    $this->db->join('appointment_tracking','appointment_request.id = appointment_tracking.appmnt_id', 'left');
    $this->db->from('appointment_request');

    // if( is_numeric($user_id) )
    $this->db->where( array("appointment_request.opened"=>2, 'sent_to_opened' => 0 ) );    
    $query = $this->db->get();
    $result_set = $query->result();
    return $result_set;

}

function update_cron_expired_emails($request_id, $request, $tracking_id, $track_details)
{
            ddf($request_id,1);
            dd($request,1);
            ddf($tracking_id,1);
            dd($track_details,1);
quit(99);
    /*  */
    $this->db->trans_start();
    $this->model_name->update($request_id, $request, 'appointment_request');
    $this->model_name->update($tracking_id, $track_details, 'appointment_tracking');
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        quit("<h3>generate an error... or use the log_message() function to log your error</h3>");
    }
    return true;

}

function insert_tracking($update_id, $selected_agent)
{
    $data_table = 'appointment_tracking';

    $details = [
        'appmnt_id' => $update_id,
        'sent_to' => $selected_agent,
        'sent_from' => 'admin',
        'sent_date' => time(),
        'sent_to_opened' => 0,
        'status' => '0',
        'admin_id' => '1'
    ];

    $new_update_id = $this->model_name->insert($details, $data_table);
    return $new_update_id;

}

function get_agents()
{
    /* get select options */
    $query = $this->ion_auth->users('Agents')->result();

    $agent_options = [];
    foreach ($query as $key => $value) {
      $query[$key]->group = $this->ion_auth->get_users_groups($value->id)->result();
      $agent_options[$value->id] = $query[$key]->first_name.' '.$query[$key]->last_name;
    }

    asort($agent_options);
    $agent_options = array(" "=>"Select Agent....") + $agent_options; 

    return $agent_options;
}

function check_status(& $dbf_data, $id)
{
    $result = $dbf_data['opened'];
    if($dbf_data['opened'] == 0) {
        $data = ['opened'=>'1'];
        $this->model_name->update($id, $data);        
        $result = '1';
    }

    return $result;
}

function get_availability($availability)
{
    if( !is_numeric($availability) )
        return $availability;

    $options = [
        "0" => "What is your availability",
        "2" => "In the Morning",
        "3" => "In the Afternoon",
        "4" => "In the Evening",
        "5" => "I'm Pretty Flexible"
    ];

    return $options[$availability];
}

function get_lead_details($update_id)
{
    //$col, $value, $orderby, $table
    $results = $this->model_name->get_by_field_name('appmnt_id', $update_id, null, 'appointment_tracking' );
    return $results;
}

/* table  appointment_request */
//id
//appmnt_date
//fullname
//phone
//email
//message
//links_agent
//availability
//select_agent
//opened
//create_date
//modified_date
//admin_id 



/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class