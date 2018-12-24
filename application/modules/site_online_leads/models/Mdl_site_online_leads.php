<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_site_online_leads extends MY_Model
{

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

function cancel_leads_email($data) {
    $agent_id = $data['select_agent'];
    $email_to   = "info@mailers.com"; //$this->model_name->get_agent_email($agent_id);
    $email_from = "info@mailers.com";
    $subject    = "Sales Lead Canceled";

    $compose_message = "Time Stamp : ".convert_timestamp( time(), 'full'); 
    $compose_message .= "<br/><br/><br/>";

    foreach ($data as $key => $value) {
      $compose_message .= ucfirst($key).": ".$value." <br/>";
    }

    $compose_message .= "<br/><br/>A sales lead for ".$data['fullname']." which was recently sent to you have been re-assigned.";    

    $compose_message .= "<br/><br/> ~Site Admin";    

    $this->load->library('MY_Email_helpers');
    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $compose_message);
}

function newleads_email($data) {
    // get agent email
    $agent_id = $data['select_agent'];
    $email_to   = "info@mailers.com";   // $this->model_name->get_agent_email($agent_id);
    $email_from = "info@mailers.com";
    $subject    = "A New Sales Lead";

    $compose_message = "Time Stamp : ".convert_timestamp( time(), 'full'); 
    $compose_message .= "<br/><br/>";        
    $compose_message .= "Message no: ".$new_update_id;
    $compose_message .= "<br/><br/><br/>";

    foreach ($data as $key => $value) {
      $compose_message .= ucfirst($key).": ".$value." <br/>";
    }

    $compose_message .= "<br/><br/>Please click on link below to accept this lead.";    
    $compose_message .= "<br/>".anchor('site_online_leads/email_response/'. $data['track_id'].'/'.$data['activation_code'], 'email_activate_link');    

    $compose_message .= "<br/><br/> ~Site Admin";    

    $this->load->library('MY_Email_helpers');
    $this->my_email_helpers->appmnt_form( $email_to, $email_from, $subject, $compose_message);

}

function get_agent_email($agent_id) {
    $results = $this->model_name->get_where($agent_id, 'users')->row();
    return $results->email;
}

function update_tracking($id, $activation_code) {
    /* first update appoinment_request then update appoinment_tracking */
    $col  = 'activation_code';
    $details = [
        'activation_code' => null,
        'opened' => 4
    ];

    $rows_updated = $this->model_name->update_byCol($col, $activation_code, $details, null);

    if( $rows_updated > 0) {
        unset($details);
        $data_table = 'appointment_tracking';
        $details = [
            'sent_to_opened' => time(),
            'comments' => ''
        ];
                                            
        $rows_updated = $this->model_name->update($id, $details, $data_table);
    }
    return $rows_updated;

}


function insert_tracking($update_id, $selected_agent){
    $data_table = 'appointment_tracking';

    $details = [
        'appmnt_id' => $update_id,
        'sent_to' => $selected_agent,
        'sent_from' => 'admin',
        'sent_date' => time(),
        'sent_to_opened' => '',
        'comments' => 'Assigned',
        'admin_id' => '1'
    ];

    $new_update_id = $this->model_name->insert($details, $data_table);
    return $new_update_id;

}

function get_agents() {
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

function check_status(& $dbf_data, $id) {
    $result = $dbf_data['opened'];
    if($dbf_data['opened'] == 0) {
        $data = ['opened'=>'1'];
        $this->model_name->update($id, $data);        
        $result = '1';
    }

    return $result;
}

function get_availability($availability) {
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

function get_lead_details($update_id) {
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