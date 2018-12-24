<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_weekly.php */

if ( ! function_exists('get_fields'))
{
  function get_fields( )
  {
      $site_user_rules = array(
            array(
              'field' => 'appmnt_date',
              'label' => 'Appmnt Date',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'date'
            ),
            array(
              'field' => 'fullname',
              'label' => 'Full Name',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'phone',
              'label' => 'Phone',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            // array(
            //   'field' => 'email',
            //   'label' => 'Email',
            //   'rules' =>'required',
            //   'icon'  => 'user',
            //   'placeholder'=>'',
            //   'input_type' => 'text'
            // ),
            // array(
            //   'field' => 'subject',
            //   'label' => 'Subject',
            //   'rules' =>'required',
            //   'icon'  => 'user',
            //   'placeholder'=>'',
            //   'input_type' => 'text'
            // ),
            array(
              'field' => 'message',
              'label' => 'Message',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'Enter message...',
              'input_type' => 'textarea'
            ),
            array(
              'field' => 'links_agent',
              'label' => 'Links Agent',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'availability',
              'label' => 'Availability',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'select_agent',
              'label' => 'Select Agent',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'select'
            ),
            array(
              'field' => 'opened',
              'label' => 'Opened',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'select'
            ),

      );
            
    return $site_user_rules;

  }// get_fields

 
} // endif