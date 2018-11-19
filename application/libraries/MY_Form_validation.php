<?php
/** application/libraries/My_Form_validation **/

class My_Form_validation extends CI_Form_validation {
	public $CI;


public function is_unique($str, $field)
	{
		sscanf($field, '%[^.].%[^.]', $table, $field);

		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		$results = $query->result();
		$result_set = $query->num_rows() === 0;

 		if( $result_set === true ) {
			return true;
		} else {
			$session_id  = $this->CI->session->userdata('is_unique_check') ?  : null;			
			$get_user_id = $results[0]->id;
			// ddf( $field." | ".$get_user_id." | ".$session_id, 1);

			return ($get_user_id == $session_id) ? true : false;
		}

		/* Not working: $this->CI->db always reads false. */
		// return isset($this->CI->db)
		// 	? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
		// 	: FALSE;
	}


public function is_valid($str, $field)
	{

		sscanf($field, '%[^.].%[^.]', $table, $field);

		$result_set = $this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 1;
		if( $result_set === true ) {
			return true;
		} else {
			$error_msg = $field.' not found. Please try again.';
 			$this->CI->form_validation->set_message( 'is_valid', $error_msg);			
			return false;			
		}
	}


public function check_user($str, $field)
	{
		$error_msg = "Login failed. Invalid username or password, or you may be locked out.";

		sscanf($field, '%[^.].%[^.]', $table, $field);

		$col1 = 'username';
		$value1 = $str;
		$col2 = 'email';
		$value2 = $str;

		$results_set = $this->CI->model_name->get_with_double_condition($col1, $value1, $col2, $value2, $table)->result();    

		if (count($results_set)<1) {
			$this->CI->form_validation->set_message('check_user', $error_msg);
			return FALSE;        
		}

		/* Safety check - if username or email is not unique */
		if (count($results_set)>1) fatal_error('VALFRM100');

		/* check password against table  */
		$password = $this->CI->input->post('password', TRUE);
		$password_on_table = $results_set[0]->password;
		$user_id = $results_set[0]->id;

  		$result = $this->CI->site_security->_verify_hash($password, $password_on_table);
		if ($result==TRUE) {
			$this->CI->session->set_userdata('user_id', $user_id);
			return TRUE;
		} else {
			$this->CI->form_validation->set_message('check_user', $error_msg);
			return FALSE;         
		}
	}

} // end My_Form_validation
