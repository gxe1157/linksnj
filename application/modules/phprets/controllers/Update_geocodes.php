<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// https://stackoverflow.com/questions/16171132/how-to-increase-maximum-execution-time-in-php
// ini_set('max_execution_time', 300); //300 seconds = 5 minutes

class Update_geocodes extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_phprets';
public $main_controller = 'Update_geocodes';
public $rets = [];

// private $get_listings = ['rnt0'=>'1/rnt',
//                          'rnt1'=>'0/res',
//                          'res0'=>'1/res',
//                          'res1'=>'0/mix',
//                          'mix0'=>'1/mix',
//                          'mix1'=>'0/2to4',
//                          '2to40'=>'1/2to4',
//                          '2to41'=>'0/bus',
//                          'bus0'=>'1/bus',
//                          'bus1'=>'0/cct',
//                          'cct0'=>'1/cct',
//                          'cct1'=>'0/lnd',
//                          'lnd0'=>'1/lnd',
//                          'lnd1'=>'done' ];

private $get_listings = ['rnt0'=>'1/rnt',
                         'rnt1'=>'0/res',
                         'res0'=>'1/res',
                         'res1'=>'0/mix',
                         'mix0'=>'1/mix',
                         'mix1'=>'0/2to4',
                         '2to40'=>'1/2to4',
                         '2to41'=>'0/bus',
                         'bus0'=>'1/bus',
                         'bus1'=>'0/cct',
                         'cct0'=>'1/cct',
                         'cct1'=>'0/lnd',
                         'lnd0'=>'1/lnd',
                         'lnd1'=>'done' ];

function __construct()
{
    parent::__construct();
    // $this->output->enable_profiler(TRUE);  
    ini_set('max_execution_time', 600);  // 10 min max
    ini_set('memory_limit', '1024M'); // use 1G

    /* set your timezone */
    date_default_timezone_set('America/New_York');

    /* pull in the packages managed by Composer */
    // require_once("./vendor/autoload.php");
    $this->load->library('MY_PHPrets');

    $file_name = APPPATH.'logs/testFile.txt';
    if( !file_exists( $file_name ) ) {
        // $this->db->truncate('rets_rnt');        
    }
}


function index($table_name, $target )
{
    // https://linksnj.com/phprets/index/0/rnt  
    // http://links.411mysite.com/phprets/index/0/rnt

    $this->log_update($table_name, $target);

    $incomplete = false;
	$sql = "SELECT * FROM $table_name WHERE IFNULL(`address`, '') = ''";
    $mls_msql = $this->model_name->custom_query($sql)->result_array();

    if(count($mls_msql)>0) {
        $incomplete = $this->my_phprets->data_geocode($mls_msql);

        /* Update retsmls tables */
        $this->model_name->update_rets_geo($table_name);

        if($incomplete==true) {
            $url = base_url().'phprets/update_geocodes/index/'.$table_name.'/'.$target.'/'.time();
            $txt .= 'from: Update_geocodes | redirect to: '.$url.PHP_EOL.PHP_EOL ;
            $this->my_phprets->write_log($txt, null);

            header("Location: $url");
            exit();                
        }
    } else {
        // quit('mls_msql: '.count($mls_msql));
    }

    $txt = 'End Geocodes: '.$table_name.PHP_EOL.PHP_EOL ;
    $this->my_phprets->write_log($txt, null);

    $this->next_listing( $table_name, $target );  

}

public function next_listing( $table, $target )  
{
    /* note: each redirects to next loop thru */

    // $login_opt | 0 = listed, 1 = sold or leased,  $ptype | 'res','rnt';
    if( $this->get_listings[$target] == 'done' ):
        $today = convert_timestamp( time(), 'full');   
        $txt = PHP_EOL.'[ '.$table.' | '.$this->get_listings[$target].' ]'.PHP_EOL;
        $txt .= PHP_EOL.'End Timestamp: '.$today.PHP_EOL;

        /* record benchmarks to log */
        $this->my_phprets->write_log($txt, null);     

        /* Send Email */
        $subject = 'Cron job '.$today;
        $contents = file_get_contents(APPPATH.'logs/testFile.txt');
        $this->load->library('MY_Email_helpers');
        $this->my_email_helpers->send_email_cron( 'gxe1157@gmail.com', $subject, $contents);

        die('Cron Job Complete');
    else:    
        $txt = PHP_EOL.'[ '.$table.' | '.$this->get_listings[$target].' ]'.PHP_EOL;
        $url = base_url().'phprets/index/'.$this->get_listings[$target];

        $txt = PHP_EOL.'from next_listing goto: '.$this->get_listings[$target].' ]'.PHP_EOL;                
        $this->my_phprets->write_log($txt, null);     
        sleep(3);
        
        redirect($url);
        exit();
    endif;
}


private function log_update($table_name, $target)
{
    $timestamp = $this->uri->segment(5);
    $txt = PHP_EOL.'UPDATE_GEOCODES ======>'.$table_name.' | '.$target.' | '.$timestamp.PHP_EOL.PHP_EOL ;
    $this->my_phprets->write_log($txt, null);

    if(is_numeric($timestamp)) {
        $txt = PHP_EOL.'*******************************************************************'.PHP_EOL;
        $txt .= 'Continue Geocodes: '.$table_name.' | '.$target.'  timestamp: '.$timestamp;
        $txt .= PHP_EOL.'******************************************************************'.PHP_EOL;
    } else {
        $txt  = 'Update Geocodes: '.$table_name.' | '.$target;
        $txt .= PHP_EOL.'----------------------------------------------------'.PHP_EOL;
    }
    $this->my_phprets->write_log($txt, null);

}

public function database_dedupe()
{
   // select all geocodes 
    $query = $this->model_name->get_all('geocodes');

    foreach ($query->result() as $key => $value)
        $geo_lookup[$value->listingid] = [ $value->latX, $value->longY,$value->address ];
}


} // End class Controller

    // $timestamp_field = 'OPENDATE';
    // $query = "({$timestamp_field}=2000-01-01T00:00:00+)";
    // $query =  "(SUBAREA=0219)";
    // $query =  "(COUNTY=Bergen)";

    // $field = 'STREET';
    // $field_value = 'Grove';
    // $query = "({$field}=$field_value )";
    // $query =  "(STATEID=NJ)";

    // https://linksnj.com/phprets/index/0/rnt
    // https://linksnj.com/phprets/update_geocodes/$table_name    
