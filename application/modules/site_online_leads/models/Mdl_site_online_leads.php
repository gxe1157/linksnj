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

function get_agents() {
    /* get select options */
    $query = $this->ion_auth->users('Agents')->result();

    $agent_options = [];
    foreach ($query as $key => $value) {
      $query[$key]->group = $this->ion_auth->get_users_groups($value->id)->result();
      $agent_options[$value->id] = $query[$key]->first_name.' '.$query[$key]->last_name;
    }

    asort($agent_options);
    $agent_options = array("0"=>"Select Agent....") + $agent_options; 

    return $agent_options;
}

function check_status(& $dbf_data, $id) {
    $result = 0;
    if($dbf_data['opened'] == 0) {
        $data = ['opened'=>'1'];
        $this->model_name->update($id, $data);        
        $result = 1;
    }

    return $result;
}


/* table  appointment_request */

// idPrimary
// appmnt_date
// fullname
// phone
// email
// subject
// message
// links_agent
// availability
// select_agent
// opened
// sent_to
// sent_date
// sent_to_opened
// create_date 

/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class