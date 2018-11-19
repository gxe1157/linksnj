<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Links_listings extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_links_listings';
public $main_controller = 'links_listings';

public $column_rules = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();

function __construct() {
    parent::__construct();

    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal';

    /* Load field data */    
    $this->load->helper('links_listings/form_flds_helper');
    $this->column_rules = get_fields();

    /* Get user data selected from manage_admin/manage */
    $update_id = $this->uri->segment(3);
    if( is_numeric($update_id) ) {
        /* is_unique_check needed in MY_Form_validation.php */
        $this->session->set_userdata('is_unique_check', $update_id);
        /* user account status */
        $results_set = $this->model_name->get_login_byid($update_id)->result();

        $this->default['username'] = $results_set[0]->username;    
        $this->default['user_status'] = $results_set[0]->active;
        $this->default['user_is_delete'] = $results_set[0]->is_deleted;
    }

    /* page settings */
    $this->default['page_nav'] = "Manage Links Property Listings";         
    $this->default['page_title'] = "Links Property Listings";    

    $this->default['page_action'] = !is_numeric($update_id) ? "Create Links Property Listing" : "Update Links Property Listing";

    $this->default['add_button']  = "Add Property Listings";
    $this->default['flash'] = $this->session->flashdata('item');

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function manage_admin()
{
    $data = $this->build_data();
    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/datatables.min',
                                'sb-admin/js/admin_js/site_loader_datatable',
                                'sb-admin/js/admin_js/site_user_details',
                                'sb-admin/js/admin_js/upload-modal-image',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];

    $data['columns'] = $this->model_name->get('listingid');
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
    // list( $data['status'], $data['user_avatar'],
    //       $data['member_id'], $data['fullname'] ) = get_login_info($user_id);

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "links_listings";    

    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/site_user_details',
                                'sb-admin/js/admin_js/upload-modal-image',
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
        $this->form_validation->set_rules( $this->column_rules );

        if($this->form_validation->run() == TRUE) {
            $data = $this->fetch_data_from_post();
            $data['admin_id'] = $this->site_security->_user_logged_in();
            $data['modified_date'] = time();

            /* convert dates here */
            $data['date_listed'] = make_timestamp_from_datepicker_us($this->input->post('date_listed', TRUE));

            if(is_numeric($update_id)){
                //update the item details
                $flash_message = "The Listings details were sucessfully updated"; 
                $this->db->trans_start();
                    $this->model_name->update($update_id, $data);
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $flash_message = "Listings update failed [Error: 100].";
                    $flash_type = "danger";                    
                    $this->email_report($flash_message." at ".__FILE__);
                }
            } else {
                //insert a new item
                $data['create_date'] = time();    

                $flash_message = "New Listing was sucessfully added"; 
                $this->db->trans_start();
                    $update_id = $this->model_name->insert($data);
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $flash_message = "Listing insert failed [Error: 102].";
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

    $data = $this->build_data( $update_id );

   /* Assign value and identify required fields */    
    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);

    /* get all agents */
    $data['agent_options'] = $this->model_name->get_all_agents();

    /* get all images on file */
    $result_set = $this->model_name->get_by_field_name('links_id', $update_id, 'position', 'links_listings_upload');
    $data['images_list'] = $result_set->result();

    /* This activates the tab panels in javascript */
    $panel_id = $this->uri->segment(4) != null ? $this->uri->segment(4) : $_POST['show_panel'];
    $data['show_panel'] = $panel_id != null ?  $panel_id : 'listings';

    /* use to disable tabpanels */
    $data['li_upload'] = is_numeric($update_id) ? '' : 'class="disabled"';
    $data['tab_toggle'] = is_numeric($update_id) ? 'data-toggle="tab"' : '';    
    
    
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
        $data['return_url'] = 'links_listings/manage_admin';        
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
      " Listing selected was sucessfully deleted" : "Listing selected failed to be deleted";
    $flash_type = $rows_updated > 0 ? 'success':'danger';
    $this->set_flash_msg($flash_message, $flash_type);      

    redirect( $this->main_controller.'/member_manage');
}

function ajax_youtube()
{
 
    $response = $this->model_name->post_youtube();
    echo json_encode($response);
}


function ajax_upload_one()
{
    $this->load->library('MY_Uploads');

    $update_id  = $this->input->post('update_id', TRUE);
    $position   = $this->input->post('position', TRUE);
    $caption    = $this->input->post('caption', TRUE);     
    $listing_id = $this->input->post('listing_id', TRUE);

    $aditional_data = [ 'links_id'  => $update_id,
                        'position'  => $position,
                        'caption'   => $caption,
                        'listing_id'=> $listing_id,                        
                      ];

    $resp_data = $this->my_uploads->ajax_upload_one($aditional_data);

 // dd($resp_data)  ;
  
    $response = array_merge($aditional_data, $resp_data);    
    echo json_encode($response);
}

function ajax_remove_one()
{
    $this->load->library('MY_Uploads');
    list($controller, $update_id, $data ) = $this->my_uploads->ajax_remove_one();
    echo json_encode($data);                
    return;
    // redirect( $controller.'/create/'.$update_id.'/upload_files' );
}


/* Users Fun facts or view_property */
function modal_fetch_ajax( $table_name = null)
{
    $this->load->library('MY_Form_model');

    $data_table =  empty($table_name) ? 'users_fun_facts' : $table_name;

    $response = $this->my_form_model->modal_fetch($data_table);
    echo json_encode($response);                
    return;    
}

function modal_post_ajax()
{

    $this->load->library('MY_Form_model');

    $update_id = $this->input->post('rowId', TRUE);
    unset($_POST['rowId']);
    $user_id = $this->input->post('user_id', TRUE);    
    $site_user_rules = array(
            array(
              'field' => 'caption',
              'label' => 'Caption',
              'rules' =>'required',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' => 'text'
            )
    );      

    $data_table = 'links_listings_upload';
    $response = $this->my_form_model->modal_post($update_id, $user_id, $site_user_rules, $data_table);
    $response['new_caption'] = $this->input->post('caption', TRUE);   
    echo json_encode($response);                
    return;    
}


// function _get_property_details($field_name, $field_value, $table_name)
// {
//     $results_set = null;
//     $query = $this->model_name->get_by_field_name( $field_name, $field_value, null, $table_name);
//     $num_rows = $query->result();

//     if($num_rows)
//         $results_set = $query->result()[0];

//     return $results_set;
// }

/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
