<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_site_weekly_ads extends MY_Model
{

function __construct( ) {
    parent::__construct();

}

function get_table() {
	// table name goes here	
    $table = "site_weekly_ads";
    return $table;
}



/* ===================================================
    Add custom model functions here
   =================================================== */

/* All users */
 
function get_all_agents()
{
    $agent_list[''] = 'Please Select...';

    $this->db->select("CONCAT_WS(', ', users.last_name, users.first_name ) AS name");
    $this->db->select('users_data.agent_id');    
    $this->db->from('users');
    $this->db->join('users_data', 'users_data.user_id = users.id', 'left');
    $this->db->join('users_groups', 'users_groups.id = users.id', 'left');    
    $this->db->where( "group_id", 2 );        
    $this->db->where("active",1);
    $this->db->order_by("users.last_name", "asc");    
    $query = $this->db->get()->result();

    foreach ($query as $key => $value)
        $agent_list[$value->agent_id] = $value->name;

    return $agent_list;    
}

/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class