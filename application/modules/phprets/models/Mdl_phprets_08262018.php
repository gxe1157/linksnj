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
    $this->db->select('id,listingid,latX,longY, address'); 
    $this->db->order_by($order_by);
    $query=$this->db->get($table);
    return $query;
}

function insert($table_name, $data){
    $table = $this->get_table();
    $this->db->insert($table_name, $data);
}

function update_rets_geo($ptype, $table_geo)
{
    $rows_updated = 0;
    
    $table_name = 'rets_'.$ptype;    
    $mysql_query = "UPDATE $table_name, $table_geo
                    SET $table_name.latX = $table_geo.latX,
                        $table_name.longY = $table_geo.longY,
                        $table_name.address = $table_geo.address
                    WHERE $table_name.listingid = $table_geo.listingid";

    $this->db->trans_start();
      $query = $this->db->query($mysql_query);
      $rows_updated = $this->db->affected_rows();      
    $this->db->trans_complete();
 
    if ($this->db->trans_status() === FALSE)
        quit("<h3>generate an error... or use the log_message() function to log your error</h3>");

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
    $this->db->delete($table_name);
}


function check_dbf($field_list, $table_name )
{
    /* Check to see if table exit if not create it */
    if ( ! $this->db->table_exists($table_name)) {
        echo "<h4>Create Table ".$table_name."</h4>";
        $this->load->module('site_migrate',$table_name);
        $this->site_migrate->up($table_name, $field_list);
    } else {
        // $this->db->empty_table($table_name);
    }
}


function insert_rets_mls(&$array, $table_name)
{
    $this->db->trans_start();
    $this->db->insert_batch($table_name, $array); 
    $this->db->trans_complete();
 
    if ($this->db->trans_status() === FALSE) {
        quit("<h3>generate an error... or use the log_message() function to log your error</h3>");
    }

    $county_table = $table_name."_ct";
    $sql = "DROP TABLE IF EXISTS ".$county_table;    
    $this->db->query($sql);             

    $mysql_query =  "CREATE TABLE ".$county_table." SELECT `COUNTY`, `AREANAME` FROM ".$table_name." group by `COUNTY`, `AREANAME`";
    $this->db->query($mysql_query);
}


/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class