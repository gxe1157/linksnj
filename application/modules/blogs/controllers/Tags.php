<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('THEMES_DIR', 'themes');
define('ADMIN_THEMES_DIR','admin');


// Rename Perfectcontroller to [Name]
class tags extends MY_Controller
{


protected $data = array();
protected $assets_path = 'assets/uploads/';
protected $current_user = array();
protected $current_groups = array();
protected $current_groups_ids = array();
protected $base_assets_url = '';
protected $parent_menu = '';
protected $page_title = '';
protected $theme = '';

/* model name goes here */
public $mdl_name = 'mdl_tags';
public $site_controller  = 'tags';

    public function __construct(){
        parent::__construct();
        // ======== Load Helper =========
        $this->load->helper('general');

        // ======== Load Library ========
        $this->load->library('general');

        $this->load->config('ci-blog');

        // $this->load->model('User');
        if($this->session->userdata('user_id')){
            $this->current_user = $this->model_name->find_by_id($this->session->userdata('user_id'));
            $this->current_groups = $this->general->current_groups();
            $this->current_groups_ids =  explode(',', $this->current_user['group_ids']);
        }

        $this->data['current_user'] = $this->current_user;
        $this->data['current_groups'] = $this->current_groups;
        $this->data['current_groups_ids'] = $this->current_groups_ids;

        if(empty($this->data['page_title'])){
            $this->data['page_title'] = $this->config->item('ci_blog_sitename');
        }


        $this->theme = $this->config->item('ci_blog_theme');





        // $this->allow_group_access(array('admin'));
        $this->data['parent_menu'] = 'post';
    }


/* ===================================================
    Controller functions goes here. Put all DRY
    functions in applications/core/My_Controller.php
  ==================================================== */

    public function index(){
        $config['base_url'] = site_url('blogs/tags/index/');
        $config['total_rows'] = count($this->model_name->find());
        $config['per_page'] = 10;
        $config["uri_segment"] = 4;
        
        $this->data['tags'] = $this->model_name->find($config['per_page'], $this->uri->segment(4));
        $this->data['pagination'] = $this->general->bootstrap_pagination($config);
        $this->general->load_admin('tags/index', $this->data);
    }

    public function add(){
        $this->form_validation->set_rules('name', 'name', 'required|is_unique[tags.name]');
        $this->form_validation->set_rules('status', 'status', 'required');

        if($this->form_validation->run() == true){
            $category = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status')
            );
            $this->model_name->create($category);
            $this->session->set_flashdata('message',message_box('Category has been saved','success'));
            redirect('blogs/tags/index');
        }

        $this->general->load_admin('tags/add');
    }

    public function edit($id = null){
        if($id == null){
            $id = $this->input->post('id');
        }

        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if($this->form_validation->run() == true){
            $category = array(
                'name' => $this->input->post('name'),
                'status' => $this->input->post('status')
            );
            $this->model_name->update($category, $id);
            $this->session->set_flashdata('message',message_box('Category has been saved','success'));
            redirect('blogs/tags/index');
        }

        $this->data['category'] = $this->model_name->find_by_id($id);
        $this->general->load_admin('tags/edit', $this->data);
    }

    public function delete($id = null){
        if(!empty($id)){
            $this->model_name->delete($id);
            $this->session->set_flashdata('message',message_box('Category has been deleted','success'));
            redirect('blogs/tags/index');
        }else{
            $this->session->set_flashdata('message',message_box('Invalid id','danger'));
            redirect('blogs/tags/index');
        }
    }


/* ===============================================
    Call backs go here...
  =============================================== */




} // End class Controller
