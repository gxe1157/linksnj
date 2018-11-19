<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_user.php */

if ( ! function_exists('get_fields_uploads'))
{
  function get_fields_uploads( )
  {

      $site_user_rules = array(
            array(
              'field' => 'caption',
              'label' => 'Property ID',
              'rules' =>'required',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'status',
              'label' => 'Status',
              'rules' =>'required',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'agents',
              'label' => 'Agents',
              'rules' => 'required',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'listing_source',
              'label' => 'Listing\'s Source',
              'rules' => 'required',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' =>'select'
            ),
            array(
              'field' => 'address',
              'label' => 'Address',
              'rules' => '',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' =>'text'
            )

      );
            
    return $site_user_rules;

  }// get_fields

 
} // endif