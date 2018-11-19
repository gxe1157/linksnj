<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_links_listings extends MY_Model
{

function __construct( ) {
    parent::__construct();

}

function get_table() {
	// table name goes here	
    $table = "links_listings";
    return $table;
}


/* ===================================================
    Add custom model functions here
   =================================================== */
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

function post_youtube()
{
    $update_id  = $this->input->post('update_id', TRUE);
    $data['youtube']    = $this->input->post('youtube', TRUE);     

    $table = $this->get_table();
    $this->db->where('id', $update_id);
    $this->db->update($table, $data);
    $rows_updated = $this->db->affected_rows();

    if($rows_updated>0){
        $response['success'] = 1;
        $response['video_name'] = $data['youtube'];
    } else {
        $response['success'] = 0;
        $response['video_name'] = '';
    }
    return $response;    
}


/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class