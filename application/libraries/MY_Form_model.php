<?php
 
class MY_Form_model extends MY_Controller
{
     public $mCi;

    //class constructor to load all required files
    function __construct(){
        parent::__construct();
        $this->mCi =& get_instance();

    }

    function modal_fetch($data_table = null)
    {

     /* tempory hack - remove */   
        // $rename_table = [ 'rets_rnt' => 'rets_RNT',
        //                   'rets_res' => 'rets_RES',
        //                   'rets_rnt_sold' => 'rets_RNT_sold',
        //                   'rets_res_sold' => 'rets_RES_sold',
        //                   'users_fun_facts' => 'users_fun_facts'
        //               ];
        // $data_table = $rename_table[$data_table];
     /* tempory hack - remove */   

        $id = $this->input->post('rowId', TRUE);
        $query = $this->model_name->get_where($id, $data_table)->result();    

        $response['mysqlRows'] = $query[0];


        $response['data_table'] =  $data_table;                    
        $response['id'] =  $id;            
        $response['success'] =  '1';            
        $response['errors_array'] = '';
        return ($response);                
    }

    function modal_post($update_id, $user_id=null, $column_rules, $data_table = null )
    {
// dd($column_rules,1);
// dd($data_table,0);

        $this->form_validation->set_rules( $column_rules );
        if($this->form_validation->run() == TRUE) {
            /* get the variables */
            $data = $this->_filter_data( $data_table, $this->input->post(null, TRUE));

            $user = $this->ion_auth->user()->row();
            $data['admin_id'] = $user->id;

            if(isset($user_id) ) $data['user_id'] = $user_id;

            /* init insert varible */
            $response['new_update_id'] = 0;
            if(is_numeric($update_id)){
                //update details
                $data['modified_date'] = time();            
                $rows_updated = $this->model_name->update($update_id, $data, $data_table);

                $response['success'] = $rows_updated > 0 ? 1: 2; // Update failed

            } else {
                //insert a new record    
                $data['create_date'] = time(); 
                $response['new_update_id'] = $this->model_name->insert($data, $data_table);

                $response['success'] = $response['new_update_id'] > 0 ? 1: 2; // Insert failed
            }

            $response['data'] = $data;
            $response['flash_message']=$flash_message;
            $response['errors_array'] = '';

        } else {
            /*  $row as each individual field array  */
            foreach($column_rules as $row){
                $field = $row['field'];                     // getting field name
                $error = form_error($field);                // getting error for field name
                if($error) $errors_array[$field] = $error;  // Add errrors to $errors_array   
            }
            $validation_errors = implode( $errors_array);

            $response['flash_message'] = $validation_errors;
            $response['success'] = '0';                
            $response['errors_array'] = $errors_array;        
        }
        return $response;
    }

    protected function _filter_data($table, $data)
    {
        $filtered_data = array();
        $columns = $this->db->list_fields($table);

        if (is_array($data))
        {
            foreach ($columns as $column)
            {
                if (array_key_exists($column, $data))
                    $filtered_data[$column] = $data[$column];
            }
        }

        return $filtered_data;
    }

}
