<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Mdl_perfectmodel to Mdl_[Name]
class Mdl_upload_categories extends MY_Model
{

function __construct( ) {
    parent::__construct();

}

function get_table() {
	// table name goes here	
    $table = "users_upload";
    return $table;
}


/* ===================================================
    Add custom model functions here
   =================================================== */
          
function update_data( $user_id, $parent_cat_id, $table_data )
{
    $table_data['parent_cat'] = $parent_cat_id;
    $update_rec = $this->check_entry( $user_id, $table_data['parent_cat'] );

    if( $update_rec == 0 )
    {
        $this->db->insert('users_upload', $table_data);
        $update_rec = $this->model_name->_get_insert_id();
    } else {
        $this->db->where('id', $update_rec);
        $this->db->update('users_upload', $table_data);
    }
    return $update_rec;
}

function check_entry( $user_id, $parent_cat_id )
{
    $this->db->select('*');
    $this->db->from('users_upload');
    $this->db->where('userid', $user_id);
    $this->db->where('parent_cat', $parent_cat_id);
    $query = $this->db->get();
    $result_set = $query->result();
    $update_rec = count($result_set) > 0 ? $result_set[0]->id : 0;

    return $update_rec;
}


/* ===============================================
    David Connelly's work from mdl_perctmodel
    is in applications/core/My_Model.php which
    is extened here.
  =============================================== */


}// end of class