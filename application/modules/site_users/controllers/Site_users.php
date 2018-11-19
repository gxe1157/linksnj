<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_users extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_users';
public $main_controller = 'site_users';

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
    $this->load->helper('site_users/form_flds_helper');
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

    /* Set page defaults */
    $this->default['page_title'] = $this->default['admin_mode'] == 'member_portal' ?  "Manage Member's Portal" : "Admin Manage Members";    

    $this->default['flash'] = $this->session->flashdata('item');
}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function manage_admin()
{
    /* ion_auth users page */
    redirect('auth/index/Agents');
}

function member_manage()
{
    redirect('auth/index/Clients');
}


function build_data( $user_id = null )
{
    list( $data['status'], $data['user_avatar'],
          $data['member_id'], $data['fullname'] ) = get_login_info($user_id);

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_users";    
    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/site_user_details',
                                'sb-admin/js/admin_js/upload-image',
                                'sb-admin/js/admin_js/users_fun_facts',
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
            /* users table data */
            $users = array(
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            );

            $data = $this->fetch_data_from_post();
            $data['user_id'] = $update_id;

            /* convert dates here */
            $data['hire_date'] = make_timestamp_from_datepicker_us($this->input->post('hire_date', TRUE));

            /* remove $users array from $data array */
            foreach ($users as $key => $value) {
                unset($data[$key]);
            }

            if( !empty($session_id) )
                 unset($_SESSION['is_unique_check']);

            // make search friendly url
            // $data['item_url'] = url_title( $data['item_title'] );

            if(is_numeric($update_id)){
                //update the item details
                $flash_message = "The Member details were sucessfully updated"; 
                $this->db->trans_start();
                    $this->model_name->update($update_id, $data, 'users_data');
                    $this->model_name->update($update_id, $users, 'users');
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $flash_message = "Member update failed [Error: 100].";
                    $flash_type = "danger";                    
                    $this->email_report($flash_message." at ".__FILE__);
                }
            } else {
                //insert a new item
                // Create record happens at ion_auth.php controller
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
    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);

    /* fetch properties */
    $fullname = $data['columns'][3]['value'].' '.$data['columns'][4]['value'];
    list($data['rnt_sold'], $data['rnt_listed'], $data['res_sold'], $data['res_listed'])=$this->model_name->get_properties_by_agent($fullname);

    /* fetch from site_users_fun_facts */
    $data['questions'] = $this->model_name->get_by_field_name('user_id', $update_id, 'list_order', 'users_fun_facts');

    /* This activates the tab panels in javascript */
    $panel_id = $this->uri->segment(4) != null ? $this->uri->segment(4) : $_POST['show_panel'];
    $data['show_panel'] = $panel_id != null ?  $panel_id : 'agent_profile';
    $data['admin_mode'] = $default['admin_mode'] == 'admin_portal' ? 0 : 1;


    $data['action'] = is_numeric($update_id) ? 'Update Record' : 'Submit';
    $data['disable_opt'] = $this->default['user_status'] ? '' : 'disabled';
    $data['update_id'] = $update_id;

    $data['view_module'] = $this->main_controller;
    $data['base_url'] = base_url();

    /* Admin Manager */
    $data['show_buttons'] = true;
    $data['cancel']     = 'manage_admin';
    $data['page_url']   = "create";

    $this->load->module('templates');
    $this->templates->admin($data);

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
    $this->load->library('MY_Uploads');
    $this->my_uploads->ajax_upload_one();
}

function ajax_remove_one()
{

    $this->load->library('MY_Uploads');
    list($controller, $update_id, $data ) = $this->my_uploads->ajax_remove_one();

    redirect( $controller.'/create/'.$update_id.'/upload_files' );
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
          'field' => 'question',
          'label' => 'Question',
          'rules' => 'required',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'answer',
          'label' => 'Answer',
          'rules' => 'required',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
    );    

    $data_table = 'users_fun_facts';
    $response = $this->my_form_model->modal_post($update_id, $user_id, $site_user_rules, $data_table);
    echo json_encode($response);                
    return;    
}


function delete_fun_fact( $id )
{
    $this->numeric_check($id);    

    $query = $this->model_name->get_where($id, 'users_fun_facts')->result();
    $user_id = $query[0]->user_id;

    $rows_updated = $this->model_name->delete($id,'users_fun_facts');
    $flash_message = $rows_updated > 0 ?
      "Fun Fact was sucessfully deleted" : "Fun Fact failed to be deleted";
    $flash_type = $rows_updated > 0 ? 'success':'danger';
    $this->set_flash_msg($flash_message, $flash_type);      

    redirect( $this->main_controller.'/create/'.$user_id.'/fun_facts');
}

/* Users Fun facts */

/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
