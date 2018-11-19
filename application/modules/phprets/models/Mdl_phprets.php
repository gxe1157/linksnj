<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_phprets extends MY_Model
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

function get_all($table)
{
    $order_by = null;
    $this->db->select('id,listingid,latX,longY, address'); 
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

function get_geocodes()
{
    // select all geocodes 
    $geo_lookup = [];
    $query = $this->model_name->get_all('geocodes')->result();

    foreach ($query as $key => $value) {
       $geo_lookup[] = ['listingid'=> $value->listingid,
                        'latX'=>$value->latX,
                        'longY'=>$value->longY,
                        'address'=>$value->address];
    }
    return $geo_lookup;
}

function update_rets_geo($table_name)
{
    $geo_data = $this->get_geocodes();
    if( empty($geo_data) ) return false;

    /* This will update all retsmlg geocode found in geocode table */
    $this->db->trans_start();
      $rows_updated = $this->db->update_batch( $table_name, $geo_data, 'listingid');
    $this->db->trans_complete();
 
    if ($this->db->trans_status() === FALSE){
        $this->load->library('MY_Email_helpers');        
        $mess_ecode = "Error : Update geocodes failed.......";
        $this->my_email_helpers->email_report($mess_ecode);
        // quit("<h3>generate an error... or use the log_message() function to log your error</h3>");
    }
    $this->db->close();

    return $rows_updated;    
}

function delete_listings($fld_name, $mysql_listing, $table_name)
{
    /* $mysql_listing is ['listingId'=>'id'] */
    // $names = array(4,5);
    foreach ($mysql_listing as $value) {
        $remove_id[] = $value;
    }
    $this->db->where_in($fld_name, $remove_id);
    $rows_deleted = $this->db->delete($table_name);
    return $rows_deleted;
}

function check_dbf($field_list, $table_name )
{
    /* Check to see if table exit if not create it */
    if ( ! $this->db->table_exists($table_name)) {
        sleep(2);        
        // echo "<h4>Create Table ".$table_name."</h4>";
        $this->load->module('site_migrate',$table_name);
        $this->site_migrate->up($table_name, $field_list);
    } else {
        // $this->db->empty_table($table_name);
    }
}

function insert_new_geo(&$array, $table_name)
{
    $this->db->trans_start();
    $this->db->insert_batch($table_name, $array); 
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        quit("<h3>generate an error... or use the log_message() function to log your error</h3>");
    }

}

function insert_rets_mls(&$array, $table_name)
{

    $this->db->trans_start();
    $this->db->insert_batch($table_name, $array); 
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        // quit("<h3>generate an error... or use the log_message() function to log your error</h3>");
    }

    $county_table = $table_name."_ct";
    $sql = "DROP TABLE IF EXISTS ".$county_table;    
    $this->db->query($sql);             

    $mysql_query =  "CREATE TABLE ".$county_table." SELECT `COUNTY`, `AREANAME` FROM ".$table_name." group by `COUNTY`, `AREANAME`";
    $this->db->query($mysql_query);

    $this->db->close();

}


/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class