<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Rename Perfectcontroller to [Name]
class Site_table_sort extends MX_Controller 
{

/* model name goes here */
public $mdl_name = 'Mdl_site_table_sort';
public $main_controller = 'site_table_sort';


function __construct()
{
  parent::__construct();
  $this->load->model( $this->mdl_name, 'model_name'); 

  /* is user logged in */
  $this->load->module('auth');
  if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');   
}



function index()
{
    $mysql_query = "SELECT id, name, position FROM country ORDER BY position";
    $data['table_array'] = $this->model_name->custom_query($mysql_query)->result();

    $this->load->view('table_sort', $data);

}

function update_positions( $table_name )
{
    if (isset($_POST['update'])) {
        foreach($_POST['positions'] as $position) {
          $index = $position[0];
          $newPosition = $position[1];

          $mysql_query = "UPDATE ".$table_name." SET position = '".$newPosition."' WHERE id='".$index."'";
          $this->model_name->custom_query($mysql_query);
        }

        exit('success');
    }
}





} //Site_table_sort














