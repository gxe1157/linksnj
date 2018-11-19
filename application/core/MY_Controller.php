<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{

public $default = [];


function __construct()
{
  parent::__construct();
  $this->load->module('site_security');
  $this->form_validation->CI =& $this;

  /* ===============================================================
     model name is assigned from $this->mdl_name to  'model_name' which is a constant
     =============================================================== */
   if( $this->mdl_name != 'mdl_' )
             $this->load->model( $this->mdl_name, 'model_name');
}

  /* ===============================================
   Add DRY funtions  // Added By Evelio Velez 05-12-2018
   =============================================== */

/* set_flash_msg */
function set_flash_msg($flash_msg, $type = null)
{
    $type = $type !=null ? $type : 'success';
    $value = '<div class="alert alert-'.$type.'" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('item', $value);
}

/* numeric_check */
function numeric_check($update_id)
{
//  quit($update_id);

    if( !is_numeric($update_id) )
        redirect('site_security/not_allowed');
}

/* get_first_record */
function get_first_record( $q, $id)  // This controller does not need a model
{
        $result_set = $q->result();
        return  $result_set[0]->$id;
}

/* search - database */
function search()
{
    $query = $_REQUEST['query'];
    // $term = $this->input->post('term', TRUE);
    $stmt = "SELECT id, email, first_name, last_name FROM staff_data
             WHERE email LIKE '%".$query."%' limit 10";

    $query = $_REQUEST['query'];

    $results_set=$this->model_name->custom_query($stmt);
    foreach ($results_set->result() as $key => $row) {
        $json[] = $row->first_name.' '.$row->last_name.' | '.$row->email;
    }

    //RETURN JSON ARRAY
    echo json_encode ($json);
}

/* Use $key_value only "field" or "label" */
function _get_column_names( $key_value )
{
    foreach ($this->column_rules as $key => $value) {
        if( $key_value == 'field' ) {
            $data[] = $this->column_rules[$key][$key_value];
        } else {
            $field  = $this->column_rules[$key]['field'];
            $data[$field] = $this->column_rules[$key]['label'];
        }
    }
    return $data;
}


function fetch_data_from_post()
{
    $field_names = $this->_get_column_names('field');
    $data = $this->model_name->fetch_data_from_post($field_names);
    return $data;
}

function fetch_data_from_db($update_id)
{
    $field_names = $this->_get_column_names('field');
    $data = $this->model_name->fetch_data_from_db($update_id, $field_names);

    if( !isset($data) )
        fatal_error('DB_ERROR_101');

    return $data;
}

} // End MY_controller

