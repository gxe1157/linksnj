<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_social_media extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_social_media';
public $main_controller = 'site_social_media';

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
    $this->load->helper('site_social_media/form_flds_helper');    
    $this->column_rules = get_fields();

    /* Get user data selected from manage_admin/manage */
    $update_id = $this->uri->segment(3);

    /* Set page defaults */
    $this->default['page_nav'] = "Manage Social Media";           
    $this->default['page_title'] = "Manage Social Media";    

    $this->default['flash'] = $this->session->flashdata('item');

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */


function manage_admin()
{

    $data = $this->build_data();

    $data['base_url'] = base_url();
    $data['columns'] = $this->model_name->get('ss_name');
    $data['page_url'] = "manage";

    $this->load->module('templates');
    $this->templates->admin($data);        
}


function build_data( $user_id = null )
{

    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_social_media";    
    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/admin_js/site_social_media',
                                'sb-admin/js/admin_js/model_js' ];

    return $data;
}    

function ajax_upload_one()
{
    $this->load->library('MY_Uploads');
    $this->my_uploads->ajax_upload_one();
}

function ajax_remove_one()
{

    $this->load->library('MY_Uploads');
    list($controller, $update_id ) = $this->my_uploads->ajax_remove_one();

    redirect( $controller.'/create/'.$update_id.'/upload_files' );
}


/* Users Fun facts */
    function modal_fetch_ajax()
    {
        $this->load->library('MY_Form_model');

        $data_table = 'site_social_media';
        $response = $this->my_form_model->modal_fetch($data_table);
        echo json_encode($response);                
        return;    
    }

    function modal_post_ajax()
    {
        $this->load->library('MY_Form_model');

        $update_id = $this->input->post('rowId', TRUE);
        unset($_POST['rowId']);
        // $user_id = $this->input->post('user_id', TRUE);    

        $data_table = 'site_social_media';
        $response = $this->my_form_model->modal_post($update_id, $user_id, $this->column_rules, $data_table);
        echo json_encode($response);                
        return;    
    }


    function delete_ss_name( $id )
    {
        $this->numeric_check($id);    

        $query = $this->model_name->get_where($id)->result();
        $user_id = $query[0]->user_id;

        $rows_updated = $this->model_name->delete($id);
        $flash_message = $rows_updated > 0 ?
          "Social Media name was sucessfully deleted" : "Fun Fact failed to be deleted";
        $flash_type = $rows_updated > 0 ? 'success':'danger';
        $this->set_flash_msg($flash_message, $flash_type);      

        redirect( $this->main_controller.'/manage_admin');
    }

/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
