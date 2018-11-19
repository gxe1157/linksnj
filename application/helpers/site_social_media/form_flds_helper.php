<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_weekly.php */

if ( ! function_exists('get_fields'))
{
  function get_fields( )
  {

      $site_user_rules = array(
            array(
              'field' => 'ss_name',
              'label' => 'Social Media Name',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'ss_url',
              'label' => 'Social Media URL',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'Enter social media url...',
              'input_type' => 'textarea'
            ),

      );
            
    return $site_user_rules;

  }// get_fields

 
} // endif