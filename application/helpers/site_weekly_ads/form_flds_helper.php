<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_weekly.php */

if ( ! function_exists('get_fields'))
{
  function get_fields( )
  {

      $site_user_rules = array(
            array(
              'field' => 'headline',
              'label' => 'Headline',
              'rules' =>'required|max_length[255]',
              'icon'  => 'user',
              'placeholder'=>'Add a great headline here....',
              'input_type' => 'text'
            ),
            array(
              'field' => 'headline_subtext',
              'label' => 'Headline Subtext',
              'rules' =>'required|min_length[10]|trim',
              'icon'  => 'user',
              'placeholder'=>'Add a paragraph or two about the property here....',
              'input_type' => 'textarea2'
            ),
            array(
              'field' => 'ad_start_date',
              'label' => 'Ad Start Date',
              'rules' => 'required',
              'icon'  => 'user',
              'placeholder'=>'Enter Ad start date',
              'input_type' =>'dates'
            ),
            array(
              'field' => 'ad_end_date',
              'label' => 'Ad End Date',
              'rules' =>'required',
              'icon'  => 'user',
              'placeholder'=>'Enter Ad end date',
              'input_type' =>'dates',
            ),

            
      );
            
    return $site_user_rules;
// user_id
// agent_name
// agent_no
// headline
// headline_subtext
// mls_listingid
// image_name
// image_org_name
// image_path
// size
// width_height  
// ad_start_date
// ad_end_date

  }// get_fields

 
} // endif