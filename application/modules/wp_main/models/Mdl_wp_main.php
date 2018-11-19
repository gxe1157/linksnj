<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_wp_main extends MY_Model
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


/* ===============================================
    David Connelly's work from mdl_perfectmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */




}// end of class