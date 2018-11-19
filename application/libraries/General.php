<?php

/*
 * Name : General Library
 * Author : Sugiarto (sugiarto@gie-art.com)
 * Date : December 24, 2015
 */

class General {

    var $CI;

    function __construct() {
        $this->CI = &get_instance();
//        $this->isLogin();
    }

    function generateRandomCode($length = 8) {
        // Available characters
        $chars = '0123456789abcdefghjkmnoprstvwxyz';

        $Code = '';
        // Generate code
        for ($i = 0; $i < $length; ++$i) {
            $Code .= substr($chars, (((int) mt_rand(0, strlen($chars))) - 1), 1);
        }
        return strtoupper($Code);
    }

    public function humanDate($datetime) {
        return date("D, d M Y H:i:s", strtotime($datetime));
    }

    public function humanDate2($date) {
        return date("D, d M Y", strtotime($date));
    }

    function generateUniqueName($fileName) {

        return $this->CI->session->userdata('session_id') . md5(date("Y-m-d H:i:s")) . md5($fileName) . '.' . $this->getFileExtension($fileName);
    }

    function getFileExtension($fileName) {
        return substr(strrchr($fileName, '.'), 1);
    }

   
    function getCategories() {
        $this->CI->load->model('Category');
        $categories = $this->CI->Category->find_active();
        return $categories;
    }

    function getTags(){
        $this->CI->load->model('Tag');
        return  $this->CI->Tag->find_active();
    }

    function getRecentPosts($limit = null){
        $this->CI->load->model('Post');
        return $this->CI->Post->find_active($limit);
    }

    function isExistFile($filename) {
//        echo $filename;exit;
        if (file_exists($filename)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    
    function isExistNextMenu($position) {
        $this->CI->load->model('Menu');
        $slide = $this->CI->Menu->getNextMenu($position);
        if (!empty($slide)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isExistPrevMenu($position) {
        $this->CI->load->model('Menu');
        $slide = $this->CI->Menu->getPrevMenu($position);
        if (!empty($slide)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    

    function getSettingByKey($key) {
        $this->CI->load->model('Setting');
        $setting = $this->CI->Setting->findByKey($key);
        if(!empty($setting)){
            return $setting;
        }else{
            return $key;
        }
    }


    function setDefaultLang() {
        $lang = $this->CI->session->userdata('language');

        if (!empty($lang)) {
            $this->CI->config->set_item('language', $this->CI->session->userdata('language'));
        } else {
            $this->CI->config->set_item('language', 'indonesian');
        }
    }

    function getDefaultLang() {
        return $this->CI->config->item('language');
    }

    function getYears() {
        $years = array();

        for ($i = date("Y"); $i > 1945; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }


    function multilevel_select($array,$parent_id = 0,$parents = array(),$selected = null) {
        
        static $i=0;
        if($parent_id==0)
        {
            foreach ($array as $element) {
                if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                    $parents[] = $element['parent_id'];
                }
            }
        }

        $menu_html = '';
        foreach($array as $element){
            $selected_item = '';
            if($element['parent_id']==$parent_id){
                if($element['id'] == $selected){
                    $selected_item = 'selected';
                }

                $menu_html .= '<option value="'.$element['id'].'" '.$selected_item.'>';
                for($j=0; $j<$i; $j++) {
                    $menu_html .= '&mdash;';
                }
                $menu_html .= $element['name'].'</option>';
                if(in_array($element['id'], $parents)){
                    $i++;
                    $menu_html .= $this->multilevel_select($array, $element['id'], $parents, $selected);
                }
            }
        }
        $i--;
        return $menu_html;
    }


    function bootstrap_menu($array,$parent_id = 0,$parents = array())
    {
        if($parent_id==0)
        {
            foreach ($array as $element) {
                if (($element['parent_id'] != 0) && !in_array($element['parent_id'],$parents)) {
                    $parents[] = $element['parent_id'];
                }
            }
        }
        $menu_html = '';
        foreach($array as $element)
        {
            if($element['parent_id']==$parent_id)
            {
                if(in_array($element['id'],$parents))
                {
                    $menu_html .= '<li class="dropdown">';
                    $menu_html .= '<a href="'.site_url($element['url']).'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$element['name'].' <span class="caret"></span></a>';
                }
                else {
                    $menu_html .= '<li>';
                    $menu_html .= '<a href="' . site_url($element['url']) . '">' . $element['name'] . '</a>';
                }
                if(in_array($element['id'],$parents))
                {
                    $menu_html .= '<ul class="dropdown-menu" role="menu">';
                    $menu_html .= $this->bootstrap_menu($array, $element['id'], $parents);
                    $menu_html .= '</ul>';
                }
                $menu_html .= '</li>';
            }
        }
        return $menu_html;
    }


    //-------------------------------------------------------------//
   
    public function load_theme($content = null, $layout = true) {
        $this->load->model('Menu');
        $this->data['main_menus'] = '';
        if(count($this->Menu->findActive()) > 0){
            $this->data['main_menus'] = $this->general->bootstrap_menu($this->Menu->findActive());
        }
        $this->data['header'] = $this->load->view('themes/'.$this->config->item('ci_blog_theme').'/header',$this->data, TRUE);
        $this->data['right_sidebar'] = $this->load->view('themes/'.$this->config->item('ci_blog_theme').'/right_sidebar',$this->data, TRUE);
        $this->data['footer'] = $this->load->view('themes/'.$this->config->item('ci_blog_theme').'/footer',$this->data, TRUE);
        

        $this->base_assets_url = 'assets/'.THEMES_DIR.'/'.$this->config->item('ci_blog_theme').'/';
        $this->data['base_assets_url'] = BASE_URI.$this->base_assets_url;
        if($layout == true){
            $this->data['content'] = (is_null($content)) ? '' : $this->load->view(THEMES_DIR.'/'.$this->config->item('ci_blog_theme').'/'.$content, $this->data, TRUE);
            $this->load->view(THEMES_DIR . '/' . $this->config->item('ci_blog_theme') . '/layout', $this->data);
        }else{
            $this->load->view(THEMES_DIR.'/'.$this->config->item('ci_blog_theme').'/'.$content, $this->data);
        }


    }

    public function load_admin($content = null, $data = null, $layout = true) {
        // $this->base_assets_url = 'sb-admin/js/assets/admin/'.$this->CI->config->item('ci_blog_admin_theme').'/';

        $this->data = $data;
        $this->data['base_assets_url'] = BASE_URI.$this->base_assets_url;

        //Category status options
        $this->data['category_status'] = array(
            0 => 'Inactive',
            1 => 'Active'
        );

        //Post status option
        $this->data['post_status'] = array(
            0 => 'Draft',
            1 => 'Publish',
            2 => 'Block'
        );

        //User status option
        $this->data['user_status'] = array(
            0 => 'Pending',
            1 => 'Active',
            2 => 'Inactive'
        );

        if(empty($this->data['parent_menu'])){
            $this->data['parent_menu'] = '';
        }
    
        if($layout == true){
            $this->data['page_url'] = $content;
            $this->CI->load->module('templates');
            $this->CI->templates->admin($this->data);    

        }else{
            $this->CI->load->view($content, $this->data);
        }
    }

    public function bootstrap_pagination($paging_config = array()){

        $this->CI->load->library('pagination');
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config = array_merge($paging_config,$config);

        $this->CI->pagination->initialize($config);
        return $this->CI->pagination->create_links(); 
    }

    public function allow_group_access($groups_allowed = array()){
        $allow_access = false;
        
        $match_group_allowed = array_intersect($this->current_groups(), $groups_allowed);
        
        $allow_access = !empty($match_group_allowed);

        if($allow_access == false){
            $this->session->set_flashdata('message', message_box('You are not allowed to access this page!','danger'));
            redirect('signin','refresh');
        }
    }

    public function current_groups(){
        $current_groups = array();
        if(!empty($this->current_user['groups'])){
            $current_groups = explode(',', $this->current_user['groups']);
        }
        return $current_groups;
    }

    public function generate_acl_db(){


        $controllers = array();
        $this->load->helper('file');

        // Scan files in the /application/controllers directory
        // Set the second param to TRUE or remove it if you 
        // don't have controllers in sub directories
        $files = get_dir_file_info(APPPATH.'controllers');
      
        // Loop through file names removing .php extension
        foreach ($files as $file)
        {
            
            $controller = array(
                'name' => $file['name'],
                'path' => $file['server_path'],
                'parent_id' => 0,
            );

            if($file['name'] != 'admin'){

                $methods = get_class_methods(str_replace('.php', '', $file['name']));
            
            }



            if($file['name'] == 'admin'){
                $admin_files = get_dir_file_info(APPPATH.'controllers/admin');
                print_data($admin_files);exit;
            }
        }
      

    }


} // end class

?>
