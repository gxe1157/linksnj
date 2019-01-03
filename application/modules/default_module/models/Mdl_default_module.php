<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_default_module extends MY_Model
{

private $mls_data = [
    // mlsId,
    listingId,
    address_full,
    address_state,
    address_city,
    property_style,
    property_area,
    property_bathsFull,
    property_bathsHalf,
    property_lotDescription,
    property_pool,
    property_bedrooms,
    parking_leased,
    parking_spaces,
    parking_description,
    parking_type,
    parking_garageSpaces,
    agreement,
    listDate,
    agent_lastName,
    agent_contact,
    agent_firstName,
    agent_id,
    photos,
    listPrice,
    mls_status
];

function __construct() {
parent::__construct();

}

function get_table() {
    // table name goes here 
    $table = "rets_mls";
    return $table;
}


/* ===================================================
    Add custom model functions here
   =================================================== */

// function test()
// {
//   quit('test');

// }

// function select_with_limit( $limit, $offset, $order_by = null) {
// return;

//     $table = $this->get_table();
//     $select = $this->mls_data;

//     $this->db->select($select);    
//     $this->db->limit($limit, $offset);
//     $this->db->order_by($order_by);
//     $query=$this->db->get($table);
//     return $query;
// }


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


// function get_login_data()
// {

//     $this->db->select('*');
//     $this->db->from('user_login');
//     $this->db->join('user_main', 'user_main.id = user_login.id');
//     $this->db->order_by("user_main.last_name", "asc");    
//     $query = $this->db->get();

//     return $query;

// }


/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class