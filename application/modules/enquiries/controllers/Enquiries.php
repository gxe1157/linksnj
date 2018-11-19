<?php
class Enquiries extends My_Controller 
{


/* model name goes here */
public $mdl_name = 'Mdl_enquiries';
public $main_controller = 'enquiries';

public $column_rules = array(
    array('field' => 'sent_to', 'label' => 'Recipient',
          'rules' => 'required','input_type' => 'search','icon'  => 'user'),
    array('field' => 'subject', 'label' => 'Subject Line',
          'rules' => 'required', 'input_type' => 'text','icon'  => 'list-alt'),
    array('field' => 'message', 'label' => 'Message',
          'rules' => 'required', 'input_type' => 'textarea')
);

// use like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );
public $default = array();

function __construct() {
    parent::__construct();
    // $this->load->helper('enquiries/form_flds_helper');

    /* page settings */
    $update_id = $this->uri->segment(3);
    // $this->default['page_title'] = "Your InBox";        
    $this->default['page_header']= 
                         !is_numeric($update_id) ? "Inbox" : "Enquiry ID: ".$update_id;
    $this->default['add_button'] = "Compose Message";
    $this->default['page_nav']   = "Your InBox";         

    $this->default['flash'] = $this->session->flashdata('item');
    $this->default['admin_mode'] = $this->session->admin_mode;    
}


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
   ==================================================== */

function submit_ranking()
{
    $submit = $this->input->post('submit', TRUE);
    $data['ranking'] = $this->input->post('ranking', TRUE);

    if ($submit=="Cancel"){
        $page_url = $this->default['admin_mode'] == 'member_portal' ? 'user_inbox':'inbox';
        redirect('enquiries/'.$page_url);
    }

    $update_id = $this->uri->segment(3);
    $this->model_name->update($update_id, $data);

    $flash_msg = "The enquiry ranking was successfully updated.";
    $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
    $this->session->set_flashdata('item', $value);
    redirect('enquiries/view/'.$update_id);
}

function _attempt_get_data_from_code($customer_id, $code)
{
    //make sure customer is allowed to view/respond and fetch data


    $query = get_by_field_name('code', $code, null, null );
    $num_rows = $query->num_rows();

    foreach($query->result() as $row) {
        $data['subject'] = $row->subject;
        $data['message'] = $row->message;
        $data['sent_to'] = $row->sent_to;
        $data['date_created'] = $row->date_created;
        $data['opened'] = $row->opened;
        $data['sent_by'] = $row->sent_by;
        $data['urgent'] = $row->urgent;
    }

    //make sure code is good and customer is allowed to view/respond
    if (($num_rows<1) OR ($customer_id!=$data['sent_to'])) {
        redirect('site_security/not_allowed');
    }

    return $data;
}

function create() 
{
    $update_id = $this->uri->segment(3);

    $submit = $this->input->post('submit', TRUE);
    if ($submit=="Submit") {
        //process the form
        $this->load->library('form_validation');
        $this->form_validation->set_rules( $this->column_rules );

        if ($this->form_validation->run() == TRUE) {
            //get the variables
            $data = $this->fetch_data_from_post();

            $data['sent_to'] = $this->_get_user_data($data['sent_to']);
            $data['date_created'] = time();
            $data['sent_by'] = 0; //admin
            $data['opened'] = 0;
            $data['code'] = $this->site_security->generate_random_string(6);

            //insert a new page
            $this->_insert($data);
            $flash_msg = "The message was successfully sent.";
            $value = '<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item', $value);
            redirect('enquiries/inbox');
        }
    }

    if( ( is_numeric($update_id) ) && ($submit != "Submit") ) {
        $fetch['columns'] = $this->fetch_data_from_db($update_id);
        $fetch['columns']['message'] = "<br><br>--------------------------------------------------<br>The original message is shown below:<br><br>".$fetch['columns']['message'];

    } else {
        $fetch['columns'] = $this->fetch_data_from_post();
    }
    
    $this->load->library('MY_Form_helpers');
    $data = $this->my_form_helpers->build_columns($data, $fetch, $this->column_rules);
    if (!is_numeric($update_id)) {
        $data['headline'] = "Compose New Message";
        $reply_to = '';        
    } else {
        $data['headline'] = "Reply To Message";
        $reply_to = $this->_enquiry_reply_to($update_id);
    }

    $data['reply_to'] = $reply_to;
    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;
    $data['labels'] = $this->_get_column_names('label');
    $data['custom_jscript'] = [ 'sb-admin/js/bootstrap3-typeahead',
                                'sb-admin/js/jquery.cleditor.min',
                                'public/js/site_loader_cleditor',
                                'public/js/site_loader_search',
                                'public/js/format_flds'];    

    $data['page_url'] = "create";
    $data['update_id'] = $update_id;

    $this->load->module('templates');
    $this->templates->admin($data);
}

function _enquiry_reply_to($update_id)
{
    $query = $this->get_where($update_id);
    $results_set = $query->result();
    $user_id = $results_set[0]->sent_by;
    $results = $this->get_where($user_id, 'users')->result();
    $reply_to = $results[0]->first_name.' '.$results[0]->last_name.'|'.$results[0]->email;

    return $reply_to;
}

function _get_user_data($sent_to)
{
    $parse_data = explode( '|', $sent_to);
    $value = trim($parse_data[1]);
    $query = $this->model_name->get_view_data_custom('email', $value, 'users', null)->result();
    $id = $query[0]->id;
    return $id;
}

function _set_to_opened($update_id)
{
    $data['opened'] = 1;
    $this->model_name->update($update_id, $data);
}


/* Admin Panel */
function inbox()
{
    $data['query'] = $this->_fetch_enquiries();
    $data['flash'] = $this->session->flashdata('item');

    $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                                'public/js/site_loader_datatable',
                                'public/js/format_flds'];    

    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;
    $data['page_url']  = "view_enquiries";   

    $this->load->module('templates');
    $this->templates->admin($data);

}

/* Member User Panel */
function user_inbox()
{
    list( $data['status'], $data['user_avatar'],
          $data['member_id'], $data['fullname'] ) = get_login_info($user_id);

    $this->load->library('MY_Form_model');    
    $data = $this->my_form_model->set_data_param( $data );

    $data['user_id'] = $user_id;
    $data['query'] = $this->_fetch_users_enquiries($user_id);

    $data['custom_jscript'] = [ 'sb-admin/js/datatables.min',
                                'public/js/site_loader_datatable',
                                'public/js/site_user_details',   
                                'public/js/member-portal' ];    

    $data['default']   = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;
    $data['page_url']  = "view_enquiries";   

    $this->load->module('templates');
    $this->templates->admin($data);
}

function view()
{
    $update_id = $this->uri->segment(3);
    $this->_set_to_opened($update_id);

    //set options for the rankings dropdown
    $options['']  = 'Select...';
    $options['1'] = 'One Star';
    $options['2'] = 'Two Stars';
    $options['3'] = 'Three Stars';
    $options['4'] = 'Four Stars';
    $options['5'] = 'Five Stars';

    $query = $this->model_name->get_where($update_id);
    $results_set = $query->result();
    $user_id = $results_set[0]->sent_by;
    $get_username = $this->model_name->get_where($user_id, 'users')->result();

    $data['username'] = $get_username[0]->first_name.' '.$get_username[0]->last_name;
    $data['options'] = $options;
    $data['update_id'] = $update_id;
    $data['query'] = $query; 

    $data['custom_jscript'] = ['public/js/enquiries'];    
    $data['default'] = $this->default;  
    $data['columns_not_allowed'] = $this->columns_not_allowed;


    /* Update member page */
    if( $this->default['admin_mode'] == 'member_portal' ) {
        $this->load->library('MY_Form_model');    
        $data = $this->my_form_model->set_data_param( $data );

        /* member manager */
        $data['return_url'] = "enquiries/user_inbox";
        // $data['cancel']     = 'member_manage';
        $data['page_url'] = "view";

        $this->load->module('templates');
        $this->templates->public_main($data);

    } else {
        /* member manager */
        $data['return_url'] = "enquiries/inbox/".$user_id;
        // $data['cancel']     = 'manage_admin';
        $data['page_url']   = "view";

        $this->load->module('templates');
        $this->templates->admin($data);
    }

}

function _fetch_enquiries()
{
    $mysql_query = "

    SELECT enquiries.*, 
        users.first_name, 
        users.last_name 
    FROM enquiries LEFT JOIN users ON enquiries.sent_by = users.id
    WHERE enquiries.sent_to=0 
    order by enquiries.date_created desc";

    $query = $this->model_name->custom_query($mysql_query);
    return $query;
}

function _fetch_users_enquiries($user_id)
{
    $mysql_query = "
    SELECT enquiries.*, 
        users.first_name, 
        users.last_name 
    FROM enquiries LEFT JOIN users ON enquiries.sent_by = users.id
    WHERE enquiries.sent_to=$user_id 
    order by enquiries.date_created desc";
    
    $query = $this->model_name->custom_query($mysql_query);
    return $query;    
}




/* ===============================================
    Callbacks go here
  =============================================== */



/* ===============================================
    David Connelly's work from perfectcontroller
    is in applications/core/My_Controller.php which
    is extened here.
  =============================================== */

// function _draw_customer_inbox($customer_id)
// {
//     $folder_type = "inbox";
//     $data['customer_id'] = $customer_id;
//     $data['query'] = $this->_fetch_customer_enquiries($folder_type, $customer_id);
//     $data['folder_type'] = ucfirst($folder_type);
//     $data['flash'] = $this->session->flashdata('item'); 
//     $this->load->view('customer_inbox', $data);   
// }



}