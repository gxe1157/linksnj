<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{


function __construct() {
    parent::__construct();

}



/* ===============================================
    Added By Evelio Velez 05-12-2018
   =============================================== */

/* get_login_byid */
function get_login_byid($user_id)
{
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('users_data', 'users_data.user_id = users.id', 'left');
    $this->db->where("users.id = '".$user_id."'" );    
    $query = $this->db->get();
    return $query;
}   

/* All users */
function get_all_users()
{
    $this->db->select('*');
    $this->db->from('users');
    $this->db->join('users_data', 'users_data.user_id = users.id', 'left');
    $this->db->order_by("users.last_name", "asc");    
    $query = $this->db->get();

    return $query;
}

/* get_by_field_name */
function get_by_field_name($col, $value, $orderby, $table) {
    $this->db->where($col, $value);
    $this->db->order_by($orderby);        
    $query=$this->db->get($table);
    return $query;
}

/* get_with_double_condition */
function get_with_double_condition($col1, $value1, $col2, $value2, $table )
{
    $this->db->where($col1, $value1);
    $this->db->or_where($col2, $value2);
    $query=$this->db->get($table);
    return $query;
}

function get_where_multiple($where, $order_by=null, $data_table = null)
{
    $table = $data_table == null ?  $this->get_table() : $data_table;        
    $this->db->where($where);    
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

function get_or_where_multiple($where, $order_by=null, $data_table = null)
{
    $table = $data_table == null ?  $this->get_table() : $data_table;        
    $this->db->or_where($where);    
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

/* Create or Update mysql */
function create_update_data($update_id=null, $data, $mess_header)
{
    $operation = ["has <b>failed</b> [Error: 100].", " was successfull."];

    $this->db->trans_start();
        if( is_numeric($update_id) ) {
            $data['modified_date'] = time();             
            $mode = "Update ";
            $this->model_name->update($update_id, $data);
        } else {    
            $data['create_date'] = time();      
            $mode = "Ceate a new ";            
            $update_id = $this->model_name->insert($data);
        }
    $this->db->trans_complete();
    $trans_status = $this->db->trans_status();

    $flash_message = $mode.' '.$mess_header.' '.$operation[$trans_status];

    if($trans_status == false) {
        $flash_type = "danger";
        $this->load->library('MY_Email_helpers');
        $this->my_email_helpers->email_report($flash_message." at ".__FILE__);
    }

    return [$update_id, $flash_message, $flash_type ];
}

/* parse_db */
function _parse_db($query, $use_fields)
{
    $data  = [];        
    foreach($query->result() as $row){
        foreach( $row as $key => $value ){
            if ( in_array($key, $use_fields) ) {
                $data[$key] = $value;            
            }    
        }    
    }
    return $data;
}

function fetch_data_from_db($update_id, $use_fields)
{
    $data = array();    
    if ( in_array('email', $use_fields) || in_array('username', $use_fields) ) {
        $query = $this->get_login_byid($update_id);
    } else {
        $query = $this->get_where($update_id);
    }

    $data  = $this->_parse_db($query, $use_fields);
    return $data;    
}

function fetch_data_from_post($use_fields)
{
    $data  = array();
    $table = $this->get_table();    
    $field_names = $this->db->list_fields($table);

    /* Merge field names from tables users_data with users */
    if ( in_array('email', $use_fields) || in_array('username', $use_fields) ) {
        $field_names = array_merge($field_names, $this->db->list_fields('users'));
    }

    foreach($field_names as $column_name){
        if($column_name != "id") {
            if ( in_array($column_name, $use_fields) ) {
                $data[$column_name] = trim($this->input->post( $column_name, TRUE));
            }
        }
    }
    return $data;
}


function fetch_columns_data() // hold this code
{
    $data  = array();
    $table = $this->get_table();    
    $mysql_query = "show columns FROM ".$table;

    $query = $this->custom_query($mysql_query);

    foreach($query->result() as $row){
        $column_name = $row->Field;
        if($column_name != "id") {
            if ( in_array($column_name, $use_fields) ) {
                $data[$column_name] = $this->input->post( $column_name, TRUE);
            }
        }
    }

    return $data;
}

/* ===============================================
    Below is Perfect Model From David Connelly
   =============================================== */

/* Get all data */
function get($order_by = null, $data_table = null){
    $table = $data_table == null ?  $this->get_table() : $data_table;    

    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

/* get_with_limit */
function get_with_limit($limit, $offset, $order_by,  $data_table = null) {
    $table = $data_table == null ?  $this->get_table() : $data_table;    

    $this->db->limit($limit, $offset);
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

/* get_where - by id*/
function get_where($id, $data_table = null){
    $table = $data_table == null ?  $this->get_table() : $data_table;    

    $this->db->where('id', $id);
    $query=$this->db->get($table);
    return $query;
}

/* insert */
function insert($data, $data_table = null ){
    $table = $data_table == null ?  $this->get_table() : $data_table;    

    $this->db->insert($table, $data);
    $query = $this->get_insert_id();
    return $query;   
}

/* get_insert_id */
function get_insert_id(){
   /* get record id number after insert completed */ 
   $last_id =  $this->db->query('SELECT LAST_INSERT_ID() as last_id')->row()->last_id;
   return $last_id;
}

/* update */
function update($id, $data, $data_table = null){
    $table = $data_table == null ?  $this->get_table() : $data_table;    

    $this->db->where('id', $id);
    $this->db->update($table, $data);
    $rows_updated = $this->db->affected_rows();
    return $rows_updated;    
}

/* delete */
function delete($id, $data_table = null ){
    $table = $data_table == null ?  $this->get_table() : $data_table;

    $this->db->where('id', $id);
    $this->db->delete($table);
    $rows_deleted = $this->db->affected_rows();
    return $rows_deleted;
}

/* count_where */
function count_where($column, $value, $data_table = null) {
    $table = $data_table == null ?  $this->get_table() : $data_table;

    $this->db->where($column, $value);
    $query=$this->db->get($table);
    $num_rows = $query->num_rows();
    return $num_rows;
}

/* count_all */
function count_all($data_table = null) {
    $table = $data_table == null ?  $this->get_table() : $data_table;

    $query=$this->db->get($table);
    $num_rows = $query->num_rows();
    return $num_rows;
}

/* get_max */
function get_max($data_table = null) {
    $table = $data_table == null ?  $this->get_table() : $data_table;

    $this->db->select_max('id');
    $query = $this->db->get($table);
    $row=$query->row();
    $id=$row->id;
    return $id;
}

function custom_query($mysql_query) {

    $query = $this->db->query($mysql_query);
    return $query;
}

} // End My_Model