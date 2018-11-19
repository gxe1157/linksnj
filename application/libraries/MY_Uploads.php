<?php
 
class MY_Uploads extends MY_Controller{
     public $mCi;


public $upload_img_base ='';

//class constructor to load all required files
function __construct()
{
    parent::__construct();
    $this->mCi =& get_instance();
    $this->upload_img_base ='./upload/';

}

function ajax_remove_one()
{
    sleep(1);
    $controller = $this->uri->segment(3) != null ?
                  $this->uri->segment(3) : $this->input->post('controller', TRUE);

    $img_id = $this->uri->segment(4) != null ?
              $this->uri->segment(4) : $this->input->post('img_id', TRUE);

    $update_id = $this->uri->segment(5) != null ?
                 $this->uri->segment(5) : $this->input->post('update_id', TRUE);

    $table_name = $this->get_table_name($controller);  

    /* full upload path */
    $upload_path = $this->_build_upload_folder($controller);
    $result_set = $this->model_name->get_by_field_name('id', $img_id, null, $table_name)->result();
    $file_name = $result_set[0]->image;

    $file_location = $upload_path.$file_name;

    /* remove file and update mysql */
    $img_parse = explode('_', $file_name);
    $data = $this->_delete_file($file_location);
    $data['remove_name'] = $img_parse[1];

    if($data['success'] == 1){
        $rows_deleted = $this->model_name->delete($img_id, $table_name);
            $flash_message = $rows_deleted > 0 ?
                $data['remove_name']." was sucessfully removed" : "Error: ".$data['remove_name']." was not removed." ;

            $flash_type = $rows_deleted > 0 ? 'success':'danger';
            $this->set_flash_msg($flash_message, $flash_type);            
    }
       
    return [$controller, $update_id, $data] ;
}


function ajax_upload_one($aditional_data=array(), $update_record=null )
{
    sleep(1);
    /* get admin_id logged in */
    $user = $this->ion_auth->user()->row();
    $admin_id = $user->id;    

    /* get post
     * $aditional_data should be used for fields like user_id or any field
     * that are extra to this dbf.
    */
    $update_id  = $this->input->post('update_id', TRUE);
    $position   = $this->input->post('position', TRUE);
    $caption    = $this->input->post('caption', TRUE);    
    $controller = $this->input->post('controller', TRUE);

    /* set image name and add ext name */
    $uploaded_file = explode('.', $_FILES['file']['name'][$position]);
    $imagename = $update_id.'_'.$uploaded_file[$position];
    $imagename .= '.'.$uploaded_file[1];

    /* full upload path */
    $upload_path = $this->_build_upload_folder($controller);

    /* check mysql for active_image */
    $is_uploaded = $this->_is_already_uploaded($controller, $imagename, $upload_path);

    if( $is_uploaded == false ){
        $this->load->library('upload', $config);

        $vector = $_FILES['file'];
        foreach($vector as $key1 => $value1)
            foreach($value1 as $key2 => $value2)
                $result[$key2][$key1] = $value2;

        $_FILES["file"]["name"] = $result[$position]["name"];
        $_FILES["file"]["type"] = $result[$position]["type"];
        $_FILES["file"]["tmp_name"] = $result[$position]["tmp_name"];
        $_FILES["file"]["error"] = $result[$position]["error"];
        $_FILES["file"]["size"] = $result[$position]["size"];

        $config["upload_path"]   = $upload_path;
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size']      = '2048';
        $config['overwrite']     = true;
        $config['file_name']     = $imagename; // set the name here

        $this->upload->initialize($config);

        if( $this->upload->do_upload('file') ) {
          $data = $this->upload->data();
          $table_data = [
             'image' => $data['file_name'],
             'orig_name' => $data['client_name'],
             'path' => $data['full_path'],
             'size' => $data['file_size'],
             'width_height' => $data['image_size_str'],
             'create_date' => time(),
             'modified_date' => time(),
             'admin_id' => $admin_id
          ];

          $table_data = array_merge($aditional_data, $table_data);
          
          $response['success'] = 1;
          $response['errors_array'] = '';

          $table_name = $this->get_table_name($controller);
          if(is_numeric($update_record)){
              //update details
              $table_data['modified_date'] = time();            
              $rows_updated = $this->model_name->update($update_record, $table_data, $table_name);
              $response['success'] = $rows_updated > 0 ? 1: 2; // Update failed

              $response['image_date'] = convert_timestamp($table_data['modified_date'], 'datepicker_us');         
              $response['image_position'] = $position;
              $response['record_id'] = $update_record;
          } else {
              //insert a new record    
              $table_data['create_date'] = time(); 
              $response['new_update_id'] = $this->model_name->insert($table_data, $table_name);
              $response['success'] = $response['new_update_id'] > 0 ? 1: 2; // Insert failed
              $num_rows = $this->model_name->get_by_field_name('links_id', $update_id, 'position', $table_name)->num_rows();

              $response['image_date'] = convert_timestamp( $table_data['create_date'], 'datepicker_us');         
              $response['image_position'] = $num_rows-1;
              $response['record_id'] = $response['new_update_id'];
          }

          /* redirect back to origin controller */
          $response['remove_name'] = $data['client_name'];
          $response['client_name'] = $data['client_name'];
          $response['full_path'] = $data['full_path'];          
          $response['redirect'] = base_url().$controller.'/create/'.$update_id.'/upload_files';

        } else {
          // display errors
          $return_message = "<p>The filetype/size you are attempting to upload is not allowed. The max-size for files is ".$config['max_size']." kb and accepted file formats are ".$config['allowed_types'].".</p>";
          $response['success'] = 0;
          $response['errors_array'] = $return_message;
          $response['error_array_console'] = $this->upload->data();
        }

    } else {
          $return_message = "<p>File is already uploaded.";
          $response['success'] = 0;
          $response['errors_array'] = $return_message;
    }

    $response['is_uploaded'] = $is_uploaded;
    $response['upload_path'] = $upload_path;    // use to debug
    // echo json_encode($response);
    return $response;
}

function _is_already_uploaded($controller, $imagename, $img_path)
{
    $table_name = $this->get_table_name($controller);
// ddf($controller.' | '.$imagename.' | '.$img_path.' | '.$table_name,1);

    $query = $this->model_name->get_by_field_name('image', $imagename, $orderby, $table_name)->result();
    $is_found = count($query)>0 ? true : false;

    if( $is_found == false){
        /* check if image is on drive and remove if found */
        $file_location  = $img_path.$imagename;
        $this->_delete_file($file_location);
    }
    return $is_found;
}

function get_table_name($controller)
{
    $table = $controller."_upload";
    return $table;   
}

function _delete_file($file_location)
{
    /* delete image file */
    $data['success'] = 1;
    $data['errors_array'] = '';

    if( file_exists( $file_location ) && !is_dir($file_location) ){
        if (!unlink($file_location)) {
            // send to log and email......
            $return_message = 'Error: File did not delete. Nofity Developer. ';
            $data['success'] = 0;
            $data['errors_array'] = $return_message;
        }
    }
    return $data;
}

function _build_upload_folder($controller = null)
{

    $prd_folder  = $controller ? $controller."/" : null;
    $upload_path = $this->upload_img_base.$prd_folder;

    if (!file_exists($upload_path) && !is_dir($upload_path))
        mkdir($upload_path, 0777, TRUE);         

    return $upload_path;
}


} //end MyUpload_lib
