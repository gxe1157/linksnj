<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// https://stackoverflow.com/questions/16171132/how-to-increase-maximum-execution-time-in-php
// ini_set('max_execution_time', 300); //300 seconds = 5 minutes

class Update_geocodes extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_phprets';
public $main_controller = 'Update_geocodes';
public $rets = [];

function __construct()
{
    parent::__construct();
    ini_set('max_execution_time', 600);  // 10 min max
    ini_set('memory_limit', '1024M'); // use 1G

    /* set your timezone */
    date_default_timezone_set('America/New_York');

    /* pull in the packages managed by Composer */
    // require_once("./vendor/autoload.php");
    $this->load->library('MY_PHPrets');

}

function index($table_name, $target )
{
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
            $txt = 'from: Update_geocodes | redirect to: '.$url.PHP_EOL.PHP_EOL ;
            $this->my_phprets->write_log($txt, null);

            header("Location: $url");
            exit();                
        }
    } else {
        // quit('mls_msql: '.count($mls_msql));
    }

    $txt = 'End Geocodes: '.$table_name.PHP_EOL.PHP_EOL ;
    $this->my_phprets->write_log($txt, null);
    die('Cron Job Complete');
 
}

public function loopback( $table, $target )  
{
    $get_listings = ['rnt0'=>'0/rnt',
                     'rnt1'=>'1/rnt', // sold
                     'res0'=>'0/res', 
                     'res1'=>'1/rnt', // sold                     
                     'mix0'=>'0/mix',
                     'mix1'=>'1/mix',// sold
                     '2to40'=>'0/2to4',
                     '2to41'=>'1/2to4',// sold
                     'bus0'=>'0/bus',
                     'bus1'=>'1/bus',// sold
                     'cct0'=>'0/cct',
                     'cct1'=>'1/cct',// sold
                     'lnd0'=>'0/lnd',
                     'lnd1'=>'1/lnd' // sold
                    ];

    $txt = PHP_EOL.'[ '.$table.' | '.$target.' | '.$this->get_listings[$target].' ]'.PHP_EOL;
    $url = base_url().'phprets/index/'.$get_listings[$target].'/1';

    $this->my_phprets->write_log($txt, null);     
    sleep(3);

    redirect($url);
    exit();
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
