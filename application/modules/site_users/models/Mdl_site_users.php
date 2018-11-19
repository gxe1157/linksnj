<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_site_users extends MY_Model
{

function __construct( ) {
    parent::__construct();

}

function get_table() {
	// table name goes here	
    $table = "users_data";
    return $table;
}



/* ===================================================
    Add custom model functions here
   =================================================== */
function get_properties_by_agent($fullname){
    $where = [ 'LAG1NAME'=> $fullname, 'SAG1NAME'=> $fullname];
    $order_by = 'AREANAME, STREET';

    $rnt_sold = $this->model_name->get_or_where_multiple($where, $order_by, 'rets_RNT_sold')->result();

    unset($where['SAG1NAME']);
    $rnt_listed = $this->model_name->get_or_where_multiple($where, $order_by, 'rets_RNT')->result();

    $where = [ 'LAG1NAME'=> $fullname, 'SAG1NAME'=> $fullname];
    $res_sold = $this->model_name->get_or_where_multiple($where, $order_by, 'rets_RES_sold')->result();

    unset($where['SAG1NAME']);
    $res_listed = $this->model_name->get_or_where_multiple($where, $order_by, 'rets_RES')->result();

    return [$rnt_sold, $rnt_listed, $res_sold, $res_listed];

}

/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class