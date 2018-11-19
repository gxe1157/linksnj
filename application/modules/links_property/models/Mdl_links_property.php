<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_links_property extends MY_Model
{


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

function test()
{
  quit('test');

}

function select_with_limit( $limit, $offset, $order_by = null) {

    $table = $this->get_table();
    $select = $this->mls_data;

    $this->db->select($select);    
    $this->db->limit($limit, $offset);
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
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