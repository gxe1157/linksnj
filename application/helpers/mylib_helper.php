<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_login_info'))
{
	function get_login_info($update_id)
	{
		if( empty($update_id) )
			return [ null, null, null, null];

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

if ( ! function_exists('dd'))
{
	function dd( $array = array(), $exit = null){
	    echo "<pre>";
	    print_r($array);
	    echo "</pre>";
	    if( empty($exit) ) exit();
	}
}

if ( ! function_exists('ddf'))
{
	function ddf( $fld = null, $exit = null){
	    echo "<h4>fld| ".$fld." |</h4>";
	    if( empty($exit) ) exit();  
	}
}

if ( ! function_exists('quit'))
{
	function quit($output = null, $exit = null){
	    echo('<h3>Debug: '.$output.'</h3>');
	    if( empty($exit) ) exit();  
	}
}

                        
if ( ! function_exists('fatal_error'))
{
	function fatal_error( $code ) {
	   die("<h3>We seem to be having techincal difficulties. Contact web developer and provide this error code: ".$code."</h3");
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
	    if(empty($date)) $date = "0000/00/00";
	    $temp=$date[5].$date[6].'/'.$date[8].$date[9].'/'.$date[0].$date[1].$date[2].$date[3];
	    return ($temp == '00/00/0000' || $temp == '//') ? null : $temp;
	}
}


if ( ! function_exists('convert_timestamp'))
{
	function convert_timestamp($timestamp, $format)	{ 
	     switch ($format) {
	         case 'info':
	         //INFO // 08 March 2018 10:15 AM 
	         $the_date = date('j F Y h:i A', $timestamp);
	         break;          

	         case 'full':
	         //FULL // Friday 18th of February 2011 at 10:00:00 AM       
	         $the_date = date('l jS \of F Y \a\t h:i:s A', $timestamp);
	         break;          
	         case 'cool':
	         //COOL // Friday 18th of February 2011          
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

if ( ! function_exists('make_timestamp_from_datepicker_us'))
{
	function make_timestamp_from_datepicker_us($datepicker)
	{
	    $hour=7;
	    $minute=0;
	    $second=0;
	    
	    $month = substr($datepicker, 0, 2);
	    $day   = substr($datepicker, 3,2);
	    $year  = substr($datepicker, 6,4);
	    
	    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	    return $timestamp;
	}
}

/* ===============================================
	Custom for this site
  =============================================== */
