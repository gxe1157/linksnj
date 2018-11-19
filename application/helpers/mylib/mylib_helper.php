<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('login_init'))
{
	function login_init( ) {
	    $ci =& get_instance();
	    $ci->load->module('site_security');  

	    $userid = $ci->site_security->_get_user_id();	    
	    $userid = is_numeric( $userid ) ? $userid : 0; // Will return userid not a true or false
//	    $login_data = $ci->model_name->get_login_byid($userid)->result();

	    $default['status']= $userid > 0 ? 1 : 0;
		$default['admin_id'] = $userid;	    /* tis user is logged */
	    $default['admin_name']= $userid>0 ? $login_data[0]->username : '';
	    $default['avatar_admin']= $userid>0 ? $login_data[0]->avatar_name : '';
 	    $default['is_admin']= $userid>0 ? $login_data[0]->is_admin : '';
 	    $default['is_deleted']= $userid>0 ? $login_data[0]->is_deleted : '';
		$default['is_logged_in'] = ( is_numeric( $userid ) ) ? true : false; 	    
	    $default['page_title'] = "";
		// checkArray($default,0);	    
	    return $default;
	}
}

if ( ! function_exists('get_login_info'))
{
	function get_login_info($update_id)
	{
	    $ci =& get_instance();

	    $results_set = $ci->model_name->get_login_byid($update_id)->result();
	    $avatar_name = $results_set[0]->avatar_name;
	    $status = $results_set[0]->status;
	    $member_id = $results_set[0]->id;
	    $avatar_name = $avatar_name !='' ? $avatar_name : 'annon_user.png';
	    $fullname = $results_set[0]->first_name.' '.$results_set[0]->last_name;
	    return [$status, $avatar_name, $member_id, $fullname];
	}
}

if ( ! function_exists('isValid_username'))
{
  function isValid_username($str) 
  {
      $ci =& get_instance();
      $ci->load->module('site_security');         

      $error_msg = "You did not enter a correct username and/or password.";

      $col1 = 'username';
      $value1 = $str;
      $col2 = 'email';
      $value2 = $str;
      $query = $ci->model_name->get_with_double_condition($col1, $value1, $col2, $value2);    
      $num_rows = $query->num_rows();

      if ($num_rows<1) {
          //$ci->form_validation->set_message('username_check', $error_msg);
          return FALSE;        
      }

      foreach($query->result() as $row) {
          $pword_on_table = $row->password;
      }

      $pword = $ci->input->post('pword', TRUE);
      $result = $ci->site_security->_verify_hash($pword, $pword_on_table);

      if ($result==TRUE) {
          return TRUE;
      } else {
         $ci->form_validation->set_message('username_check', $error_msg);
         return FALSE;         
      }
  }
}// end


if ( ! function_exists('checkArray'))
{
	function checkArray( $array = array(), $exit){
	    echo "<pre>";
	    print_r($array);
	    echo "</pre>";
	    if( empty($exit) ){
	        exit();  
	    }
	}
}

if ( ! function_exists('checkField'))
{
	function checkField( $fld = null, $exit){
	    echo "<h4>fld| ".$fld." |</h4>";
	    if( empty($exit) ){
	        exit();  
	    }
	}
}


if ( ! function_exists('quit'))
{
	function quit($output = null, $exit = null){
	    echo('<h3>Debug Position: '.$output.'</h3>');
	    if( empty($exit) ) exit();  
	}
}

if ( ! function_exists('base_dir'))
{
	function base_dir(){
    	$base_dir = explode('application', APPPATH);
    	return $base_dir[0];
	}
}


if ( ! function_exists('SQLformat_date'))
{
	function SQLformat_date($date){
	    $temp=$date[6].$date[7].$date[8].$date[9].'-'.$date[0].$date[1].'-'.$date[3].$date[4];
	    return $temp;
	}
}

if ( ! function_exists('format_date'))
{
	function format_date($date){
	    if(empty($date)) $date ="0000/00/00";
	    $temp=$date[5].$date[6].'/'.$date[8].$date[9].'/'.$date[0].$date[1].$date[2].$date[3];
	    return ($temp == '00/00/0000' || $temp == '//') ? null : $temp;
	}
}


if ( ! function_exists('convert_timestamp'))
{
	function convert_timestamp($timestamp, $format)	{ 
     
	     switch ($format) {
	         case 'full':
	         //FULL // Friday 18th of February 2011 at 10:00:00 AM       
	         $the_date = date('l jS \of F Y \a\t h:i:s A', $timestamp);
	         break;          
	         case 'cool':
	         //FULL // Friday 18th of February 2011          
	         $the_date = date('l jS \of F Y', $timestamp);
	         break;                  
	         case 'datepicker_us':
	         //DATEPICKER  // 2/18/11         
	         $the_date = date('m\/d\/Y', $timestamp); 
	         break;  
	     }
	     return $the_date;
	}
}

if ( ! function_exists('current_file'))
{
	function current_file($file) {
	    $current_file = explode('/', $file);
	    $current_file = end($current_file);
	    return $current_file;
	}
}

    $current_file = explode('/', $_SERVER['SCRIPT_NAME']);
    $current_file = end($current_file);

if ( ! function_exists('last_referer'))
{
	function last_referer() {
	   $current_file = explode('/', $_SERVER['HTTP_REFERER']);
	   $array_count = count($current_file);
	   $new_array = $current_file[ $array_count-2 ]."/".$current_file[ $array_count -1];
	   return $new_array;
	}
}


if ( ! function_exists('required_fields'))
{
	function required_fields($column_rules){
        $field_name = '';		
	    foreach ($column_rules as $key => $value) {
	        if( $column_rules[$key]['rules'] ){            
	            $field_name = $column_rules[$key]['field'];
	            $req_flds[$field_name] = '<span style="font-size: 1.2em">*</span>';
	        }
	    }
	    return $req_flds;
	}
}


/* ===============================================
	Custom for this site
  =============================================== */


if ( ! function_exists('image_pagination'))
{
	function image_pagination( $imgDir ){
	    $bm_pages = array();
	    if (is_dir(FCPATH.$imgDir)){
	        if ($dirHandle = opendir(FCPATH.$imgDir)){
	            while($file = readdir($dirHandle)){
	                if ( $file != 'Thumbs.db' && $file != "." && $file != ".." ) {
	                    $bm_pages[] = base_url().$imgDir.'/'.$file;
	                 }
	            }
	            closedir($dirHandle);
	        }
	    }
	    
	    if( count($bm_pages) == 0 ){
	         $bm_pages[] = base_url().'public/images/404-error-page.jpg';
	    }

	    return $bm_pages;
	}

}

if ( ! function_exists('create_links'))
{
	function create_links( $bm_pages ) {
	    $x = 0;
	    $get_link = 'Page: ';
	    foreach( $bm_pages as $key => $value) {   
	        $x++;
	        $get_link .= '<a id="img'.$x.'" href="javascript:nextPage('.$x.')" >&nbsp;&nbsp;'.$x.' </a> ';
	    }
	    return $get_link;
	}
}


