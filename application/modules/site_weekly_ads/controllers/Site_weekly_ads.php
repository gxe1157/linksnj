<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_weekly_ads extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_weekly_ads';
public $main_controller = 'site_weekly_ads';

public $column_rules = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();


function __construct() {
    parent::__construct();

    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) 
          redirect('auth/login', 'refresh');


    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal';

    $this->load->helper('site_weekly_ads/form_flds_helper');
    $this->column_rules = get_fields();

    /* get user data selected from manage_admin/manage */
    $update_id = $this->uri->segment(3);
    if( is_numeric($update_id) ) {
        $this->session->set_userdata('is_unique_check', $update_id); // MY_Form_validation.php
        /* user account status */
        $results_set = $this->model_name->get_login_byid($update_id)->result();
        $this->default['username'] = $results_set[0]->username;    
        $this->default['user_status'] = $results_set[0]->active;
        $this->default['user_is_delete'] = $results_set[0]->is_deleted;
    }
    /* get user data selected from manage_admin */

    /* page settings */
    $this->default['page_nav'] = "Manage Weekly Sales Ad Input";         
    $this->default['page_title'] = "Manage Weekly Sales Ad Input";    

    $this->default['page_action'] = !is_numeric($update_id) ? "Create Weekly Sales Ad" : "Update Weekly Sales Ad";

    $this->default['add_button']  = "Add Weekly Sales Ad";
    $this->default['flash'] = $this->session->flashdata('item');

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function manage_admin()
{
    $data = $this->build_data();
   
    $data['columns'] = $this->model_name->get('create_date');
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->admin($data);        
}

function member_manage()
{
    $this->load->library('MY_Form_model');

    $user_id = $this->site_security->_user_logged_in();
    $data = $this->build_data( $user_id );

    $data = $this->my_form_model->set_data_param( $data );
    $data['columns'] = $this->model_name->get_where($user_id);
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->public_main($data);
}

function build_data( $user_id = null )
{
    list( $data['status'], $data['user_avatar'],
          $data['member_id'], $data['fullname'] ) = get_login_info($user_id);

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_weekly_ads";    

    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/admin_js/jquery-ui.min',
                                'sb-admin/js/admin_js/site_loader_table-sort',

                                'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',

                                'sb-admin/js/admin_js/site_user_details',
                                'sb-admin/js/admin_js/site_weekly_ads',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];

    return $data;
}    

function create()
{
    $update_id = $this->uri->segment(3);

    $cancel = $this->input->post('cancel', TRUE);
    if( $cancel == "member_manage" || $cancel == "manage_admin")
        redirect($this->main_controller.'/'.$cancel);

    $submit = $this->input->post('submit', TRUE);
    if( $submit == "Submit" ) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules( $this->column_rules );

        if($this->form_validation->run() == TRUE) {
            $data = $this->fetch_data_from_post();
            $data['admin_id'] = $this->site_security->_user_logged_in();
            $data['modified_date'] = time();
            $data['ad_start_date'] = make_timestamp_from_datepicker_us($data['ad_start_date']);
            $data['ad_end_date'] = make_timestamp_from_datepicker_us($data['ad_end_date']);

            if( !empty($session_id) )
                 unset($_SESSION['is_unique_check']);

            if(is_numeric($update_id)){
                //update the item details
                $flash_message = "The Ad Sales details were sucessfully updated"; 
                $this->db->trans_start();
                    $this->model_name->update($update_id, $data);
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $flash_message = "Ad Sales update failed [Error: 100].";
                    $flash_type = "danger";                    
                    $this->email_report($flash_message." at ".__FILE__);
                }

            } else {
                //insert a new item
                $data['create_date'] = time();    

                $flash_message = "New Ad Sales was sucessfully added"; 
                $this->db->trans_start();
                    $update_id = $this->model_name->insert($data);
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $flash_message = "Ad Sales insert failed [Error: 102].";
                    $flash_type = "danger";                    
                    $this->email_report($flash_message." at ".__FILE__);
                }

            }

            $this->set_flash_msg($flash_message, $flash_type);      
            redirect($this->main_controller.'/create/'.$update_id.'/'.$_POST['show_panel']);

        } else {
            // echo validation_errors();
        }
    }

    if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
        $fetch['columns'] = $this->fetch_data_from_db($update_id);
    } else {
        $fetch['columns'] = $this->fetch_data_from_post();
    }

    /* build $data array to pass to template */
    $data = $this->build_data( $update_id );

    /* Assign value and identify required fields */    
    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);

    /* get all agents and modal options */
    $data['agent_options'] = array_merge( array(''=>'Please Select...'), $this->model_name->get_all_agents() );
    $data['status_options'] = array('' => 'Please Select....', '1'=>'Available', '2'=>'Under Contract', '3'=>'Sold');
    $data['listing_source_options'] = array('' => 'Please Select....', '1' => 'MLS', '2' => 'Links');    

    /* get all images on file */
    $result_set = $this->model_name->get_by_field_name('weekly_ad_id', $update_id, 'position', 'site_weekly_ads_placed');
    $data['images_list'] = $result_set->result();

    /* This activates the tab panels in javascript */
    $panel_id = $this->uri->segment(4) != null ? $this->uri->segment(4) : $_POST['show_panel'];
    $data['show_panel'] = $panel_id != null ?  $panel_id : 'weekly_ad_info';
    $data['admin_mode'] = $default['admin_mode'] == 'admin_portal' ? 0 : 1;

    $data['action'] = is_numeric($update_id) ? 'Update Record' : 'Submit';
    $data['update_id'] = $update_id;

    $data['module'] = $this->main_controller;
    $data['base_url'] = base_url();

    /* Update member page */
    if( $this->default['admin_mode'] == 'member_portal' ) {
        $this->load->library('MY_Form_model');    
        $data = $this->my_form_model->set_data_param( $data );

        /* member manager */
        $data['show_buttons'] = false;        
        $data['cancel']     = 'member_manage';
        $data['page_url']   = "create";

        $this->load->module('templates');
        $this->templates->public_main($data);

    } else {
        /* Admin Manager */
        $data['show_buttons']     = true;
        $data['cancel']     = 'manage_admin';
        $data['return_url'] = 'site_weekly_ads/manage_admin';        
        $data['page_url']   = "create";

        $this->load->module('templates');
        $this->templates->admin($data);
    }

}

function delete( $id )
{
    $this->numeric_check($id);    
    $rows_updated = $this->delete($id);

    $flash_message = $rows_updated > 0 ?
      " Member selected was sucessfully deleted" : "Member selected failed to be deleted";
    $flash_type = $rows_updated > 0 ? 'success':'danger';
    $this->set_flash_msg($flash_message, $flash_type);      

    redirect( $this->main_controller.'/member_manage');
}

function ajax_upload_one()
{
    /* This will upload image file to id number from modal_post_ajax */
    $response = $this->modal_post_ajax(true);

    if($response['success'] == 1 ) {
        $this->load->library('MY_Uploads');
        $table_aditional_data = [
            'weekly_ad_id' => $this->input->post('update_id', TRUE),      
            'caption' => $this->input->post('caption', TRUE),
            'status'  => $this->input->post('status', TRUE),
            'agents'  => $this->input->post('agents', TRUE),
            'listing_source' => $this->input->post('listing_source', TRUE)
        ];

        $update_record = $response['new_update_id'];
        $data = $this->my_uploads->ajax_upload_one($table_aditional_data, $update_record );
        echo json_encode($data);

    } else {
        echo json_encode( $response);       
        return;
    }  

}

function remove_one()
{
    $delete_id = $this->uri->segment(3);
    $weekly_ad_id = $this->uri->segment(4);

    $table_name = 'site_weekly_ads_placed';
    $rows_deleted = $this->model_name->delete($delete_id, $table_name);

    $flash_message = $rows_deleted > 0 ?
        $data['remove_name']." was sucessfully removed" : "Error: ".$data['remove_name']." was not removed." ;

    $flash_type = $rows_deleted > 0 ? 'success':'danger';
    $this->set_flash_msg($flash_message, $flash_type);           

    redirect( 'site_weekly_ads/create/'.$weekly_ad_id.'/upload_files' );
}

function modal_fetch_ajax()
{
    $response['success'] = 1;
    $listing_id = $this->input->post('listingId', TRUE);    
    $listingSource = $this->input->post('listingSource', TRUE);   
    $mode = $this->input->post('mode', TRUE);   

    $field_value = $listing_id;
    $field_name  = $listingSource == 1 ? 'MLSNUMBER' : 'id';
    $table_name  = $listingSource == 1 ? 'rets_RES':'site_weekly_ads_placed';

    /* debug mode */
    $response['mode'] = $mode;
    $response['listing_id'] = $listing_id;    
    $response['listing_source'] = $listingSource;    
    $response['field_list'] = $field_name.' | '.$field_value.' | '.$table_name;      
    /* debug mode */

    if($mode == 'new_record'){
        $result_set = $this->_get_property_details('caption', $field_value, 'site_weekly_ads_placed');

        if( $result_set != null ) {
            $response['flash_message'] = 'Listing Id Number : '.$listing_id.' has already been selected.<br />Please enter a new Listing Id Number.';

            $response['success'] = 0;

            echo json_encode($response);                
            return;    
        }
    }

    $response['mysqlRows'] =
            $this->_get_property_details($field_name, $field_value, $table_name);

    if($response['mysqlRows'] == null ){
        $response['success'] = 0;
        $response['flash_message'] = 'Record not found.';        
    }

    echo json_encode($response);                
    return;    
}

function modal_post_ajax($opt=null)
{
    $this->load->library('MY_Form_model');

    $this->load->helper('site_weekly_ads_placed/form_flds_helper');
    $this->column_rules = get_fields_uploads();

    $update_id = $this->input->post('rowId', TRUE);
    $update_id = trim($update_id);
    unset( $_POST['rowId'], $_POST['base_url'] );  

    $response['response'] = $this->my_form_model->modal_post($update_id, $user_id, $this->column_rules, 'site_weekly_ads_placed');

    $response['success'] = $response['response']['success'];
    $response['flash_message'] = $response['response']['flash_message'];

    $response['new_record'] = empty($update_id) ? 1: 0;   

    if( $opt == null ){
        echo json_encode($response);                
        return;    
    } else {
        return $response;
    }   
}

function _get_property_details($field_name, $field_value, $table_name)
{
    $results_set = null;
    $query = $this->model_name->get_by_field_name( $field_name, $field_value, null, $table_name);
    $num_rows = $query->result();

    if($num_rows)
        $results_set = $query->result()[0];

    return $results_set;
}

/* ===============================================
    Callbacks go here
  =============================================== */

// address:"875 Devon St, Kearny, NJ 07032, USA"
// latX:"40.77848500"
// longY:"-74.13385500"
// photos:"http://pxlimages.xmlsweb.com/rets/l/Images/1544378.1.jpg"
// MLSNUMBER:"1544378"

// admin_id:"1"
// agents:"1"
// caption:"1541218"
// create_date:"1529250090"
// id:"8"
// image:"1_Koala.jpg"
// listing_source:"2"
// modified_date:"1529287295"
// orig_name:"Koala.jpg"
// path:"C:/xampp/htdocs/links/upload/site_weekly_ads/1_Koala.jpg"
// position:"0"
// size:"763"
// status:"2"
// weekly_ad_id:"1"
// width_height:"width="1024" height="768"


/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
