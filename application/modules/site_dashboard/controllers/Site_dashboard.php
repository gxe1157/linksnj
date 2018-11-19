<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_dashboard extends MY_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_dashboard';
public $main_controller = 'site_dashboard';

public $flash_msg = '';

public $default = [];

function __construct($data = null) {
    parent::__construct();

    $this->load->module('auth');
    if (!$this->ion_auth->logged_in())
        redirect('auth/login', 'refresh');
 
    $this->default['page_nav'] = "Dashboard";  
    $this->default['flash']    = $this->session->flashdata('item');
}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

function welcome()
{
    $data['custom_jscript'] = '';
    $data['page_url'] = 'welcome';
    $data['view_module'] = 'site_dashboard';
    $data['title'] = "Welcome";

    $this->default['page_title'] = 'Dashboard Page';    
    $data['default'] =  $this->default;  

    $this->load->module('templates');
    $this->templates->admin($data);     
}


function settings()
{
    $data['custom_jscript'] = '';
    $data['page_url'] = 'settings';
    $data['view_module'] = 'site_dashboard';
    $data['title'] = "Site Settings";

    $this->default['page_title'] = 'Site Settings Page';
    $data['default'] =  $this->default;  

    $this->load->module('templates');
    $this->templates->admin($data);     
}


// function logout()
// {
//     $this->_end_session();        
//     redirect(base_url().admin);
// }

// function _end_session()
// {
//     unset($_SESSION['user_id']);
//     unset($_SESSION['admin_mode']); 
//     unset($_SESSION['is_logged_in']); 
//     unset($_SESSION['is_admin']);

//     $this->load->module('site_cookies');
//     $this->site_cookies->_destroy_cookie();

//     $this->auth->logout();
// }

/* ===============================================
    Call backs go here...
  =============================================== */


/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller

// function contactus()
// {
//     $data['custom_jscript'] = ['public/js/contact-us',
//                                'sb-admin/js/bootstrapValidator.min'
//                               ];
//     $data['page_url'] = 'contact-us';
//     $data['view_module'] = 'site_dashboard';
//     $data['title'] = "Welcome";

//     $this->default['page_nav'] = "Contact Us";  
//     $this->default['page_title'] = 'Contact Us';    
//     $data['default'] =  $this->default;  

//     $this->load->module('templates');
//     $this->templates->admin($data);     
// }


// function contactus_ajaxPost()
// {
//     /* Send Email */
//     if( ENV != 'local' ) {
//       $from = $_POST['email'];
//       $subject = "NJPOB: Contact Us Form";
//       $message = "Time Stamp : ".convert_timestamp( time(), 'full')."\n\n";
//       foreach( $_POST as $fld_name => $fld_value){
//         $message .= $fld_name." : ".$fld_value."\n";
//       }
//       $message .= "\n\nRecord Number : ".$rec_num."\n\n";

//       $this->contactus_mail($from, $subject, $message);     
//     }
// }


// function contactus_mail($from, $subject, $message)     
// {

//     if( ENV != 'local' ) {
//         // send email to jdmedical
//         $email       = 'info@mailers.com';
//         $admin_email = 'webmaster@411mysite.com';
//         $from        = $_POST['email'];

//         $this->load->library('email');
//         $this->email->from( $from);
//         $this->email->to($email);
//         $this->email->cc();
//         $this->email->bcc($admin_email);

//         $this->email->subject($subject);
//         $this->email->message($message);

//         $this->email->send();
//     }
//     if ( ! $this->email->send()) {
//          // Generate log error
//          echo "Email was not sent!...";                    
//     }
// }

// function check_password_ajax()
// {
    
//     // $this->load->module('site_security');
//     $userid = $this->site_security->_make_sure_logged_in();

//     $results_set = $this->model_name->get_view_data_custom('id', $userid, 'staff_login', null)->result();
//     $pword_on_table = $results_set[0]->password;

//     $old_password = $this->input->post('old_password', TRUE);
//     $result = $this->site_security->_verify_hash($old_password, $pword_on_table);

//     if ($result==TRUE) {
//         echo 1;
//     } else {
//         echo 0;
//     }
// }
