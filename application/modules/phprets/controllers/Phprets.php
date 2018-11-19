<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// https://stackoverflow.com/questions/16171132/how-to-increase-maximum-execution-time-in-php
// ini_set('max_execution_time', 300); //300 seconds = 5 minutes

class Phprets extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_phprets';
public $main_controller = 'phprets';
public $rets = [];

private $Username = null;
private $Password = null;
private $LoginUrl = null;

private $get_photo_data = 1; // turn on or off


function __construct()
{
    parent::__construct();
    // $this->output->enable_profiler(TRUE);  
    ini_set('max_execution_time', 600);  // 10 min max
    // ini_set('memory_limit', '1024M'); // use 1G
    ini_set('memory_limit', '2048M'); // use 2G

    // ini_get('safe_mode') ?  ddf('safe mode is on') : ddf('safe mode is off');

    /* set your timezone */
    date_default_timezone_set('America/New_York');

    /* pull in the packages managed by Composer */
    require_once("./vendor/autoload.php");
    $this->load->library('MY_PHPrets');

    $file_name = APPPATH.'logs/testFile.txt';
    if( !file_exists( $file_name ) ) {
        // $this->db->truncate('geocodes');                
        $this->db->truncate('rets_rnt');        
    }
}

public function index()
{
    /* init vars */
    $limit  = '99999';
    $login_opt = $this->uri->segment(3);  // 0 = listed, 1 = sold or leased
    $ptype = $this->uri->segment(4);   	//'res','rnt' to uppercase in do_search();
    $query = 'STATEID=NJ';
    /* end init vars */

    $data_type = $this->credentials($login_opt);
    $this->my_phprets->connect_mls($this->LoginUrl, $this->Username, $this->Password);

    $table_name = 'rets_'.$ptype.$data_type;
    $target = $ptype.$login_opt;
// quit($table_name);

    /* Do Search and get back results */
    list($mls_msql, $process_complete ) = $this->my_phprets->do_search($ptype, $query, $limit, $this->get_photo_data, $table_name);

    $this->my_phprets->disconnect_rets();

    if( count($mls_msql)>0 ) {
        $field_list = array_keys($mls_msql[0]);
        $this->model_name->check_dbf($field_list, $table_name );
        $this->model_name->insert_rets_mls($mls_msql, $table_name);
    }

	if( $process_complete == true ) {
	    /* Assign geo codes from Google */
	    $url = base_url().'phprets/update_geocodes/index/'.$table_name.'/'.$target.'/'.time();
	    $txt .= 'from: Phprets (Complete)| redirect to: '.$url.PHP_EOL.PHP_EOL ;
	    $this->my_phprets->write_log($txt, null);

    } else {
    	/* Loop back and get the rest of MLS files */
        $url =  base_url().'phprets/update_geocodes/next_listing/'.$table_name.'/'.$target;
        $txt .= 'from: Phprets (LoopBack)| redirect to: '.$url.PHP_EOL.PHP_EOL ;
        $this->my_phprets->write_log($txt, null);

    }              

	redirect($url);
    exit();

}

private function credentials($sold=null)
{
    /* credential from mysql */
    $this->LoginUrl = 'http://rets-njmls.xmlsweb.com/rets/login';
    if( $sold ==1 ) {
        $this->Username = 'MARC STEIN-RETS3-SOLD';
        $this->Password = '1TTHHI';
        $data_type= '_sold';
    } else {
        $this->Username = 'MARC STEIN-RETS3';
        $this->Password = 'UIAQZM';
        $data_type= '';
    }

    return $data_type;
}

/* updated by evelio for Andy */
public function get_images($type, $id)
{
    header('Content-Type: application/json');
    $array = [];

    // replace function connect_mls with this line.
    $this->credentials();
    $this->rets = $this->my_phprets->connect_mls($this->LoginUrl, $this->Username, $this->Password);

    // search query
    $results = $this->rets->Search(
        'Property',
        $type,
        'LISTINGID='.$id,
        ['Limit' => 1, 'Format' => 'COMPACT-DECODED']
    );

    $this->rets->Disconnect();

    // loop through results
    foreach ($results as $r) {
        // create temp array to append to our object
        // grab all photo objects
        $photosObject =
             $this->rets->GetObject("Property", "Photo", $r->get('LISTINGID'), "*", 1);

        foreach ($photosObject as $photo) {
            // push each url onto the temp array
            array_push($array, $photo->getLocation());
        }
        // set the array of pics
        $r['photos'] = json_encode($array);
		$r['photos'] = stripslashes (str_replace ('\/', '/', $r['photos']));
		$r['photos'] = json_decode($r['photos'], TRUE);
    }

    $json = json_encode($array);
    echo $json;
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


    // http://links.411mysite.com/phprets/index/0/rnt
    // http://links.411mysite.com/phprets/update_geocodes/$table_name
    // cron setting: wget http://links.411mysite.com/phprets/index/0/rnt/res >/dev/null 2>&1    

    // https://linksnj.com/phprets/index/0/rnt
    // https://linksnj.com/phprets/update_geocodes/$table_name    

    // ddf($this->uri->segment(1),1); //CONTROLLER
    // ddf($this->uri->segment(2),1); // FUNCTION 1
    // ddf($this->uri->segment(3),1); // FUNCTION 2
    // ddf($this->uri->segment(4),1);