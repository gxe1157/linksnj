<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Default_module extends MY_Controller
{
// https://www.youtube.com/watch?v=qOjGSI5OdIo
/* model name goes here */
public $mdl_name = 'Mdl_default_module';
public $main_controller = 'default_module';
public $column_rules = [];

// used like this.. in_array($key, $columns_not_allowed ) === false )
public $columns_not_allowed = array( 'create_date' );


function __construct() {
    parent::__construct();

}


function index()
{

	$first_bit = trim($this->uri->segment(1) );
	$second_bit = trim($this->uri->segment(2) );

	if( !empty($first_bit) ){
		$data['page_url'] = $first_bit == 'index.html' ? 'main' : strtolower($first_bit);

	} else {
		$data['page_url'] = 'main';		
	}

    /* Get Agents names as options */
	// $data['agent_options'] = $this->model_name->get_agents();

	// $limit= 8;
	// $offset= 0;
	// $order_by = '';
 //    $data['rets_mls'] = $this->model_name->select_with_limit($limit, $offset, $order_by); 

	// $limit= 8;
	// $offset= 8;
 //    $data['rets_mls2'] = $this->model_name->select_with_limit($limit, $offset, $order_by); 

 //    $data['photo']    = $second_bit;

	$this->load->module('templates');
	$this->templates->public_main($data);

}


function admin( $data = array() )
{

    if( !isset( $data['view_module'] ) )
        $data['view_module']= $this->uri->segment(1);

    $this->load->view('admin/admin', $data);
}


} // End class Controller



















	// $this->load->module('webpages');
	// $query = $this->webpages->get_where_custom('page_url', $first_bit);
	// $num_rows = $query->num_rows();

	// if($num_rows > 0) {
	// 	//we have found content... load page
	// 	foreach($query->result() as $row ){
	// 		$data['page_url'] = strtolower($row->page_url);
	// 		$data['page_title'] = $row->page_title;
	// 		$data['page_keywords'] = $row->page_keywords;
	// 		$data['page_description'] = $row->page_description;
	// 		$data['page_content'] = $row->page_content;
	// 	}

	// } else {
	// 	echo "<h1>Page Not Found 2 ".$first_bit."</h1>"; 

	// 	$data['page_url'] = '404_page';
	// 	$this->load->module('site_settings');
	// 	$data['page_content'] = $this->site_settings->_get_page_not_found_msg();
	// }



