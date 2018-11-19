<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_helpers
{
  public $ci;

    public function __construct()
    {
        // $this->ci =& get_instance(); 
        //Allows you to access CI components
    }

	public function build_columns( & $data, & $fetch,  & $column_rules)
	{
	    /* Add field value, mark required fields and
	       count validation errors from post or mysql */ 
	    $cnt_errors = 0;
	    $error_mess = [];      
	    $data['req_flds'] = $this->required_flds($column_rules);

	    $active = 1;
	    $model_style = '<span style=\'font-size: 1.3em; font-weight: bold;\'><b>||</b></span><br>';

	    $data['columns'] = $column_rules;       
	    foreach ($data['columns']  as $key => $value) {
	        $field_name = $data['columns'][$key]['field'];
	        $label_value = $data['columns'][$key]['label'];
	        $field_type = $data['columns'][$key]['input_type'];
	        $data['columns'][$key]['label'] = $label_value." ".$data['req_flds'][$field_name];

	        /* Assign mysql or post value here */            
	        $value = $fetch['columns'][$field_name];
	        $data['columns'][$key]['value'] = $field_type == 'dates' ? $this->format_date($value) : $value;

	        if( $key <= 5 && $active == 1 )
	            $field_panel_name = str_replace('||', 'Company Information: ', $model_style);
	        if( $key >= 6 && $active == 1)
	            $field_panel_name = str_replace('||', 'Service Provided: ', $model_style);
	        
	        /* Build and count validation errors array */
	        if( form_error($field_name) ) {
	            $cnt_errors++;
	            $error = form_error($field_name);
	            $new_error_mess = strip_tags($error);
	            array_push($error_mess, $field_panel_name.$new_error_mess );
	            $field_panel_name = '';
	            $active = 0;
	        }     
	        /* Activate Service Provided header for modal */
	        if( $key == 9 ) $active = 1; 
	    }

	    $data['cnt_errors'] = $cnt_errors;
	    $data['error_mess'] = implode( "<br>", $error_mess ); 
	    return $data;
	}

	private function format_date($value)
	{
	    if(empty($value)){
	    	$date = "0000/00/00";
		    $value = $date[5].$date[6].'/'.$date[8].$date[9].'/'.$date[0].$date[1].$date[2].$date[3];
		}



        $date = convert_timestamp($value, 'datepicker_us') == "01/01/1970" ?
           "00/00/0000" : convert_timestamp($value, 'datepicker_us');

        return $date;
	}

	private function required_flds(& $column_rules)
	{
        $field_name = '';		
	    foreach ($column_rules as $key => $value) {
            $column_rule = $column_rules[$key]['rules'];
	        if( strpos($column_rule, 'required') !== false ){     
	            $field_name = $column_rules[$key]['field'];
	            $req_flds[$field_name] = '<span style="color: red; font-size: 1.4em"> * </span>';
	        }
	    }
	    return $req_flds;
	}


}