<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* site_user.php */

if ( ! function_exists('get_fields'))
{
  function get_fields( )
  {

      $site_user_rules = array(
            array(
              'field' => 'agent_id',
              'label' => 'Agent Id Number',
              'rules' => 'required|is_unique[users_data.agent_id]', //'required|is_natural|is_unique[users_data.agent_id]',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'username',
              'label' => 'Username',
              'rules' => 'required|is_unique[users.username]',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'email',
              'label' => 'Email',
              'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
              'icon'  => 'envelope',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'first_name',
              'label' => 'First Name',
              'rules' =>'required|min_length[3]|max_length[40]',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'last_name',
              'label' => 'Last Name',
              'rules' =>'required|min_length[3]|max_length[40]',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'middle_name',
              'label' => 'Middle Name',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' => 'text'
            ),
            array(
              'field' => 'phone',
              'label' => 'Phone',
              'rules' => 'required',
              'icon'  => 'earphone',
              'placeholder'=>'(201) 999-9999',
              'input_type' =>'text'
            ),
            array(
              'field' => 'ext',
              'label' => 'Extension',
              'rules' => '',
              'icon'  => 'earphone',
              'placeholder'=>'9999',
              'input_type' =>'text'
            ),
            array(
              'field' => 'fax',
              'label' => 'Fax',
              'rules' => '',
              'icon'  => 'earphone',
              'placeholder'=>'(201) 999-9999',
              'input_type' =>'text'
            ),
            array(
              'field' => 'cell_phone',
              'label' => 'Cell Phone',
              'rules' =>'',
              'icon'  => 'phone',
              'placeholder'=>'(201) 999-9999',
              'input_type' =>'text'
            ),
            array(
              'field' => 'hire_date',
              'label' => 'Hire Date',
              'rules' =>'',
              'icon'  => 'calendar',
              'placeholder'=>'',
              'input_type' =>'dates'
            ),
            array(
              'field' => 'job_title',
              'label' => 'Job Title',
              'rules' => 'min_length[3]|max_length[100]',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'designations',
              'label' => 'Designations',
              'rules' =>'',
              'icon'  => 'phone',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'job_description',
              'label' => 'Bio',
              'rules' => '',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' =>'textarea2'
            ),
            array(
              'field' => 'office_location',
              'label' => 'Office Location',
              'rules' =>'',
              'icon'  => '',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'facebook',
              'label' => 'Facebook',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'Enter username',
              'input_type' =>'text'
            ),
            array(
              'field' => 'linkedin',
              'label' => 'Linkedin',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'instagram',
              'label' => 'Instagram',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            ),
            array(
              'field' => 'twitter',
              'label' => 'Twitter',
              'rules' =>'',
              'icon'  => 'user',
              'placeholder'=>'',
              'input_type' =>'text'
            )
      );

// user_name
// email
// first_name
// last_name
// middle_name
// phone
// cell_phone
// hire_date
// temination_date
// termination_reason

// avatar_name
// position
// profile_description
// office_location

 	  return $site_user_rules;

  }// get_fields

 
} // endif