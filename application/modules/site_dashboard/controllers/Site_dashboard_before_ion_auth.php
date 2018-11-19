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
    // checkArray($this->default,0);
    if( !$default['is_logged_in']  ){
       // quit( uri_string() );
    }

    $this->default['page_nav'] = "Dashboard";  
    $this->default['flash']    =$this->session->flashdata('item');
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

function contactus()
{
    $data['custom_jscript'] = ['public/js/contact-us',
                               'sb-admin/js/bootstrapValidator.min'
                              ];
    $data['page_url'] = 'contact-us';
    $data['view_module'] = 'site_dashboard';
    $data['title'] = "Welcome";

    $this->default['page_nav'] = "Contact Us";  
    $this->default['page_title'] = 'Contact Us';    
    $data['default'] =  $this->default;  

    $this->load->module('templates');
    $this->templates->admin($data);     
}


function contactus_ajaxPost()
{
    /* Send Email */
    if( ENV != 'local' ) {
      $from = $_POST['email'];
      $subject = "NJPOB: Contact Us Form";
      $message = "Time Stamp : ".convert_timestamp( time(), 'full')."\n\n";
      foreach( $_POST as $fld_name => $fld_value){
        $message .= $fld_name." : ".$fld_value."\n";
      }
      $message .= "\n\nRecord Number : ".$rec_num."\n\n";

      $this->contactus_mail($from, $subject, $message);     
    }
}


function contactus_mail($from, $subject, $message)     
{

    if( ENV != 'local' ) {
        // send email to jdmedical
        $email       = 'info@mailers.com';
        $admin_email = 'webmaster@411mysite.com';
        $from        = $_POST['email'];

        $this->load->library('email');
        $this->email->from( $from);
        $this->email->to($email);
        $this->email->cc();
        $this->email->bcc($admin_email);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }
    if ( ! $this->email->send()) {
         // Generate log error
         echo "Email was not sent!...";                    
    }
}


function login()
{
    if( $_SESSION['is_logged_in'] )
        redirect( $main_controller.'/welcome');

    $data['custom_jscript'] = '';
    $data['page_url'] = 'login';
    $data['view_module'] = 'site_dashboard';
    $data['title'] = "Admin Login";

    $data['default'] =  $this->default;  
    $this->default['page_title'] = 'Login';

    $this->load->module('templates');
    $this->templates->admin($data); 
}


function submit_login()
{

    $submit = $this->input->post('submit', TRUE);
    if ($submit=="Submit") {
        $this->form_validation->set_rules('username', 'Username',
                 'required|min_length[5]|max_length[60]|check_user[staff_login.username]');

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[35]');

        if ($this->form_validation->run() == TRUE) {
            //figure out the user_id
            $col1 = 'username';
            $value1 = $this->input->post('username', TRUE);
            $col2 = 'email';
            $value2 = $this->input->post('username', TRUE);
            $table = 'staff_login' ;

            $query = $this->model_name->get_with_double_condition($col1, $value1, $col2, $value2, $table );

            foreach($query->result() as $row) {
                $user_id = $row->id;
                $account_status = $row->status;
             }

            /* member is not active - redirect to not active page */
            if($account_status == 0) {
                $this->_set_flash_msg("We could not sign you in at this time. If you are a new member, check your email for membership signup validation. For further assistance contact membership support.");        
                redirect('site_dashboard/login');
            }
              
            $remember = $this->input->post('remember', TRUE);
            if ($remember=="remember-me") {
                $login_type = "longterm";
            } else {
                $login_type = "shortterm";
            }

            $data['last_login'] = time();
            $this->model_name->update($user_id, $data);

            //send them to the private page
            $this->_in_you_go($user_id, $login_type);

        }
    }
    $this->login();
}

function activate($security_code=null)
{
    $submit = $this->input->post('submit-form', TRUE);
    $security_code = $submit != null ? $this->input->post('activate_code', TRUE) : $security_code;

    $results_set = $this->model_name->get_view_data_custom('security_code', $security_code,
     'staff_login', null);

    if( count($results_set->result()) == 0 ) {
        $this->_set_flash_msg("There seems to be a problem activating the account. For help in resolving this, please contact membership support.");
        redirect('site_dashboard/login');
    }    


    foreach($results_set->result() as $row) {
        $user_id = $row->id;
    }    

    if ($submit=="Submit") {
        // $this->load->module('site_security');        
        $new_password = $this->input->post('password', TRUE);
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password',
         'trim|required|matches[password]');

        if ($this->form_validation->run() == TRUE) {
            $login_type = "shortterm";
            $data['last_login'] = time();
            $data['status'] = 1;                        
            $data['user_priv'] = 1;                                    
            $data['user_access'] = 1;                                                
            $data['security_code'] = '';  
            $data['password'] = $this->site_security->_hash_string($new_password);
            $this->model_name->update($user_id, $data);
   
        } else {
            echo validation_errors();
        }

    }

    $data['activate_code'] =  $security_code;
    $data['custom_jscript'] = 'reg_pswrd';
    $data['page_url'] = 'password_form';
    $data['view_module'] = 'site_dashboard';    
    $data['title'] = "Membership Login";

    $this->default['page_title'] = 'Member Portal';
    $data['default'] =  $this->default;  


    $this->load->module('templates');
    $this->templates->admin($data); 

}

function forgot_password()
{

     $submit = $this->input->post('submit', TRUE);
    if ($submit=="Send My Password") {
        //process the form
        $this->form_validation->set_rules('email', 'email',
            'required|min_length[5]|max_length[60]|valid_email|is_valid[staff_login.email]');

        if ($this->form_validation->run() == TRUE) {
            $email = $this->input->post('email', TRUE);

            $results_set = $this->model_name->get_view_data_custom(
                           'email', $email, 'staff_login', $orderby = null)->result();

            $user_id = $results_set[0]->id;

            $expire_date = time() + (3 * 24 * 60 * 60); // 3 days; 24 hours; 60 mins; 60 secs
            $random_str  = $this->site_security->generate_random_string(20);
            $data['status'] = 0;                        
            $data['user_priv'] = 0;                                    
            $data['last_login'] = time();
            $data['security_code']  = $expire_date.$random_str;
            $data['password'] = $this->site_security->_hash_string('Smokey{2012}');            

            $this->model_name->update($user_id, $data);

            /* send rest password email */
            $this->send_mail($email, 'recover', $data['security_code'] );                 

            $this->flash_msg =
              "We have received your password reset request. Please check your email for further instructions.";
            $this->_set_flash_msg($this->flash_msg);

        } else {
           // echo validation_errors();
 
        }
    }

    $data['flash'] = $this->flash_msg ? $this->session->flashdata('item') : '';   
    $data['email'] = $this->input->post('username', TRUE);

    $data['custom_jscript'] = '';
    $data['page_url'] = 'forgot_password';
    $data['view_module'] = 'site_dashboard';
    $data['title'] = "Password Recovery";

    $this->default['page_title'] = 'Forgot Password';
    $data['default'] =  $this->default;  

    $this->load->module('templates');
    $this->templates->admin($data);     

}


function change_password()
{

    $userid = $this->site_security->_make_sure_logged_in();

    $password  = $this->input->post('password', TRUE);
    $submit    = $this->input->post('submit-form', TRUE);

    if($submit == 'Cancel'){
        redirect( 'site_dashboard/welcome' );
    }    

    $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_password');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password',
     'trim|required|matches[password]');

    if ($this->form_validation->run() == TRUE) {
        /* update database */
        $data['last_login'] = time();
        $data['password']    = $this->site_security->_hash_string($password);        
        $this->model_name->update($userid, $data);

        /* send email notification of password change */
        $this->send_mail( $this->_check_email, 'recover', null);        
/* fix this */

        $this->_end_session();    
        $this->login();

    } else {
       /* found username or email inside password */
       echo validation_errors();
    }

}

function check_password_ajax()
{
    
    // $this->load->module('site_security');
    $userid = $this->site_security->_make_sure_logged_in();

    $results_set = $this->model_name->get_view_data_custom('id', $userid, 'staff_login', null)->result();
    $pword_on_table = $results_set[0]->password;

    $old_password = $this->input->post('old_password', TRUE);
    $result = $this->site_security->_verify_hash($old_password, $pword_on_table);

    if ($result==TRUE) {
        echo 1;
    } else {
        echo 0;
    }
}


function logout()
{
    $this->_end_session();        
    redirect(base_url().admin);
}

function _end_session()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['admin_mode']); 
    unset($_SESSION['is_logged_in']); 
    unset($_SESSION['is_admin']);

    $this->load->module('site_cookies');
    $this->site_cookies->_destroy_cookie();

}


function _in_you_go($user_id, $login_type)
{
    $this->session->set_userdata('admin_mode', 'admin_portal');    
    //NOTE: the login_type can be longterm or shortterm
    if ($login_type=="longterm") {
        //set a cookie
        $this->load->module('site_cookies');
        $this->site_cookies->_set_cookie($user_id);
    } else {
        //set a session variable
        $this->session->set_userdata('user_id', $user_id);
        $this->session->set_userdata('is_logged_in', true);  
        $this->session->set_userdata('is_admin', true);                      
    }
    //send the user to the private page
    $url_location ='site_dashboard/welcome';

    redirect($url_location);
}


function site_404page()
{

    $data['custom_jscript'] = '';
    $data['page_url'] = 'site_404page';
    $data['view_module'] = 'partials';
    $data['title'] = "Page Not Found";

    $this->default['page_title'] = '';
    $data['default'] =  $this->default;  

    $this->load->module('templates');
    $this->templates->admin($data);     

}


function test1()
{
    $your_name = "David";
    $this->session->set_userdata('your_name', $your_name);
    echo "The session variable was set.";

    echo "<hr>";
    echo anchor('site_dashboard/test2', 'Get (display) the session variable')."<br>";
    echo anchor('site_dashboard/test3', 'Unset (destry) the session variable')."<br>";
}

function test2()
{
    $your_name = $this->session->userdata('your_name');
    if ($your_name!="") {
        echo "<h1>Hello $your_name</h1>";
    } else {
        echo "No session variable has been set for your_name";
    }

    echo "<hr>";
    echo anchor('site_dashboard/test1', 'Set the session variable')."<br>";
    echo anchor('site_dashboard/test3', 'Unset (destry) the session variable')."<br>";
}

function test3()
{
    unset($_SESSION['your_name']);
    echo "The session variable was unset.";

    echo "<hr>";
    echo anchor('site_dashboard/test1', 'Set the session variable')."<br>";
    echo anchor('site_dashboard/test2', 'Get (display) the session variable')."<br>";
}




/* ===============================================
    Call backs go here...
  =============================================== */


/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */


} // End class Controller
