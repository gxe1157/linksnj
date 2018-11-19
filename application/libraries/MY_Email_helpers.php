<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email_helpers extends MY_Controller
{
	public function __construct()
	{
    	parent::__construct(); // Construct CI's core so that you can use it
	}

	function contact_form($email_to, $email_from, $subject, $message)
	{
	    if( ENV != 'live')  return false;

        $to        = $email_to;
        $from      = $email_from;
		$bcc_email = 'webmaster@411mysite.com, jpkinsley@gmail.com, anthony@linksnj.com, joe@linksnj.com';

    	$this->process_email($from, $to, $bcc_email, $subject, $message );
	}

	function email_report($mess_ecode)
	{
	    if( ENV != 'live')  return false;

	    $to        = 'webmaster@411mysite.com';
	    $from      = 'web server';
		$bcc_email = null;	    
	    $subject   = 'Problem at : '.base_url();
	    $message   = $mess_ecode;

		$this->process_email($from, $to, $bcc_email, $subject, $message );
	}

	function send_admin_email($type)
	{
	    if( ENV != 'live')  return false;

	    $results_set = $this->model_name->get_by_field_name('type', $type, null, 'site_admin_emails')->result();

	    $to        = 'webmaster@411mysite.com';	    
	    $from      = $results_set[0]->from;
		$bcc_email = $results_set[0]->bcc_email;
	    $subject   = $results_set[0]->subject;
	    $message   = $results_set[0]->body;

	    $domain  = base_url();
	    $message = sprintf($message, $domain, $mess_ecode);

		$this->process_email($from, $to, $bcc_email, $subject, $message );
	}


	function send_email_cron( $to, $subject, $report_results)
	{
	    if( ENV != 'live')  return false;

	    $to        = 'webmaster@411mysite.com';	    
	    $from      = 'cron@411mysite.com';
		$bcc_email = '';

		$this->process_email($from, $to, $bcc_email, $subject, $report_results );

	}


	public function process_email($from, $email, $bcc_email=null, $subject, $message )
	{
        $this->email->from($from);
        $this->email->to($email);
        if( !empty($bcc_email) ) $this->email->bcc($bcc_email);        
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();

	    // if ( ! $this->email->send() ) {
	    //         // Generate log error
	    // }
	}

}