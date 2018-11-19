<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_settings extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_settings';
public $main_controller = 'site_settings';

public $column_rules = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();


function __construct()
{
    parent::__construct();

    /* is user logged in */
    $this->load->module('auth');
    if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

    /* Set admin mode */
    $this->default['admin_mode'] = $this->ion_auth->is_admin() ? 'admin_portal':'member_portal';

    /* Load field data */    
    // $this->load->helper('site_users/form_flds_helper');
    $this->column_rules = $this->get_fields();

    /* Set page defaults */
    $this->default['page_title'] = "Site Settings";    

}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function manage_admin()
{

    /* Check to see if table is empty */
    $update_id = $this->db->count_all('site_settings') == 0 ? null : 1;

    if( is_numeric($update_id) ) {
        $data = $this->fetch_data_from_db($update_id);
    } else {
        $data = $this->fetch_data_from_post();
    }

    /* Get user data selected from manage_admin/manage */
    $data = $this->build_data($data);

    $data['page_url'] = "settings";
    $data['update_id'] = $update_id;
    $this->load->module('templates');
    $this->templates->admin($data);
}

function build_data($data)
{
    $data['title'] = $this->default['page_title'];           
    $data['default'] = $this->default;  
    $data['view_module'] = "site_settings";    
    $data['custom_jscript'] = [ 'sb-admin/js/admin_js/site_init',
                                'sb-admin/js/jquery.cleditor.min',
                                'sb-admin/js/admin_js/site_loader_cleditor',
                                'sb-admin/js/admin_js/site_user_details',
                                'sb-admin/js/admin_js/upload-image',
                                'sb-admin/js/admin_js/model_js',
                                'sb-admin/js/admin_js/format_flds'];

    return $data;
}    


function update_site_settings($field_grp)
{
    $this->load->library('MY_Form_model');
    $this->column_rules = $this->get_fields($field_grp);
// dd($this->column_rules);

    /* Check to see if table is empty */
    $update_id = $this->db->count_all('site_settings') == 0 ? null : 1;

    $table_name = 'site_settings';
    $user_id = null;
    $response = $this->my_form_model->modal_post($update_id, $user_id, $this->column_rules, $table_name);
   
   $this->session->set_flashdata($field_grp, $response['flash_message']);

   redirect('site_settings/manage_admin');

// dd($response['flash_message'])    ;

    // echo json_encode($response);                
    // return;        

}

function get_fields($get_array=null)
{

    $company_location_info = array(
        // array(
        //   'field' => 'company_name',
        //   'label' => 'Company Name',
        //   'rules' => 'required|trim|min_length[5]|max_length[100]',
        //   'icon'  => 'user',
        //   'placeholder'=>'',
        //   'input_type' =>'text'
        // ),
        array(
          'field' => 'company_address',
          'label' => 'Company Address',
          'rules' => 'required|trim|min_length[5]|max_length[50]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_address2',
          'label' => 'Company Address2',
          'rules' => 'required|trim|min_length[5]|max_length[50]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_city',
          'label' => 'Company City',
          'rules' => 'required|trim|max_length[50]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),

        array(
          'field' => 'company_state',
          'label' => 'Company State',
          'rules' => 'required|trim|max_length[2]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_zip',
          'label' => 'Company Zip',
          'rules' => 'required|trim|min_length[5]|max_length[10]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        )
    );    

    $company_contacts_info = array(
        array(
          'field' => 'company_phone',
          'label' => 'Company Phone',
          'rules' => 'required|trim|max_length[14]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_fax',
          'label' => 'Company Fax',
          'rules' => 'required|trim|max_length[14]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_email',
          'label' => 'Company Email',
          'rules' => 'required|trim|valid_email',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'company_contact_email',
          'label' => 'Company Contact Email',
          'rules' => 'required|trim|valid_email',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        )
    );    

    $uploadimage1 = array(
        array(
          'field' => 'company_logo_top',
          'label' => 'Company Logo Top',
          'rules' => 'required|trim|min_length[5]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        )
    );

    $uploadimage2 = array(
        array(
          'field' => 'company_logo_footer',
          'label' => 'Company Logo Footer',
          'rules' => 'required|trim|min_length[5]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        )
    );    

    $google_api_key = array(
        array(
          'field' => 'google_maps_geo',
          'label' => 'Google Maps Geo Codes',
          'rules' => 'required|trim|min_length[5]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
        array(
          'field' => 'google_api_key',
          'label' => 'Google API Key',
          'rules' => 'required|trim|min_length[5]',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        )
    );    

    $add_javascript = array(
        array(
          'field' => 'add_javascript',
          'label' => 'Add Javascript',
          'rules' => 'required|trim',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
    );    

    $facebook_pixels = array(
        array(
          'field' => 'facebook_pixels',
          'label' => 'Facebook Pixels',
          'rules' => 'required|trim',
          'icon'  => 'user',
          'placeholder'=>'',
          'input_type' =>'text'
        ),
    );    



    $all_data = array_merge($company_location_info, $company_contacts_info,
                            $uploadimage1, $uploadimage2, $google_api_key,$add_javascript,
                            $facebook_pixels);


    $response =  $get_array != null ? $$get_array: $all_data;
    return $response;

}

function add_javascript()
{
    // add_javascript
    
}

function facebook_pixels()
{
    // facebook_pixles     
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


/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
