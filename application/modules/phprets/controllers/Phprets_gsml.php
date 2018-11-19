<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// https://stackoverflow.com/questions/16171132/how-to-increase-maximum-execution-time-in-php
// ini_set('max_execution_time', 300); //300 seconds = 5 minutes

class Phprets_gsml extends MY_Controller
{

/* model name goes here */
public $mdl_name = 'Mdl_phprets';
public $main_controller = 'phprets_gsml';

private $Username = null;
private $Password = null;
private $LoginUrl = null;
private $UserAgent = null;
private $UserAgentPassword = null;
private $RetsVersion = null;
private $HttpAuthenticationMethod = null;

private $get_photo_data = 1; // turn on or off

function __construct()
{
    parent::__construct();
    // $this->output->enable_profiler(TRUE);  
    ini_set('max_execution_time', 600);  // 10 min max
    ini_set('memory_limit', '1024M'); // use 1G

    /* set your timezone */
    date_default_timezone_set('America/New_York');

    /* pull in the packages managed by Composer */
    require_once("./vendor/autoload.php");
    $this->load->library('MY_PHPrets_gsml');

}

public function index()
{
    // https://linksnj.com/phprets/phprets_gsml/index/0/rnt

    /* init vars */
    $limit  = '99999';
    $login_opt = $this->uri->segment(4);  // 0 = listed, 1 = sold or leased
    $ptype = $this->uri->segment(5);   //'res','rnt' to uppercase in do_search();
    $query = null; // Query assigned in library MY_PHPrets
    /* end init vars */

    $data_type = $this->credentials($login_opt);
    $this->my_phprets_gsml->connect_mls($this->LoginUrl, $this->Username, $this->Password,
                                        $this->UserAgent, $this->UserAgentPassword,
                                        $this->RetsVersion, $this->HttpAuthenticationMethod );

    $table_name = 'gsml_'.$ptype.$data_type;
// quit($table_name)    ;

    $target = $ptype.$login_opt;

    /* Do Search and get back results */
    list($mls_msql, $process_complete ) = $this->my_phprets_gsml->do_search($ptype, $query, $limit, $this->get_photo_data, $table_name);

    $this->my_phprets_gsml->disconnect_rets();
quit('new 88');

    if( count($mls_msql)>0 ) {
        $field_list = array_keys($mls_msql[0]);
        $this->model_name->check_dbf($field_list, $table_name );
        $this->model_name->insert_rets_mls($mls_msql, $table_name);
    }

    if( $process_complete == true ) {
        /* Assign geo codes from Google */
        $url = base_url().'phprets/update_geocodes/index/'.$table_name.'/'.$target.'/'.time();
        $txt .= 'from: Phprets (Complete)| redirect to: '.$url.PHP_EOL.PHP_EOL ;
        $this->my_phprets_gsml->write_log($txt, null);

    } else {
        /* Loop back and get the rest of MLS files */
        // $url = 'phprets/index/'.$login_opt.'/'.$ptype;
        $url =  base_url().'phprets/update_geocodes/next_listing/'.$table_name.'/'.$target;
        $txt .= 'from: Phprets (LoopBack)| redirect to: '.$url.PHP_EOL.PHP_EOL ;
        $this->my_phprets_gsml->write_log($txt, null);

    }              

    redirect($url);
    // header("Location: $url");
    exit();

}

private function credentials($sold=null)
{
    /* credential from mysql */
    $this->LoginUrl = 'https://rets2.gsmls.com/rets_idx/login.do';
    $this->Username = 'JosephKinsley';
    $this->Password = '27NWLFEFICES';
    $this->UserAgent = 'JosephKinsley/1.0';
    $this->UserAgentPassword = 'NF3U4ZUZ';
    $this->RetsVersion = '1.8';
    $this->HttpAuthenticationMethod = 'digest';

    $data_type =  $sold ==1 ? '_sold' : '';
    return $data_type;
}


/* updated by evelio for Andy */
public function get_images($type, $id)
{
	// https://linksnj.com/phprets/phprets_gsml/get_images/rnt/3456790
	//https://github.com/troydavisson/PHRETS/wiki/getObjectIdx
    // header('Content-Type: application/json');
    $array = [];

    // replace function connect_mls with this line.
    $this->credentials();
    // $this->LoginUrl = 'https://rets2.gsmls.com:443/rets_idx/getObjectIdx.do';
    $this->rets = $this->my_phprets_gsml->connect_mls($this->LoginUrl,
                                                      $this->Username,
                                                      $this->Password,
                                                      $this->UserAgent,
                                                      $this->UserAgentPassword,
                                                      $this->RetsVersion,
                                                      $this->HttpAuthenticationMethod );

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
             $this->rets->GetObject("Property", "Photo", $r->get('LISTINGID'), "0", 1);

foreach ($photosObject as $photo) {
    dd($photo);
        $listing = $photo->Content-ID;
        $number = $photo->Object-ID;

        if ($photo->Success == true) {
                echo "{$listing}'s #{$number} photo is at {$photo['Location']}\n";
                quit(88);
        }
        else {
                echo "({$listing}-{$number}): {$photo->ReplyCode} = {$photo->ReplyText}\n";
                quit(99);                
        }
}

// $photos = $this->rets->GetObject("Property", "Photo", $r->get('LISTINGID'), "0", 0);
// foreach ($photos as $photo) {
//         $listing = $photo['Content-ID'];
//         $number = $photo['Object-ID'];

//     if ($photo['Success'] == true) {
//         $contentType = $photo['Content-Type'];
//         $base64 = base64_encode($photo['Data']); 
// 		echo "<img src='data:{$contentType};base64,{$base64}' />";
//     }
//     else {
//         echo "({$listing}-{$number}): {$photo['ReplyCode']} = {$photo['ReplyText']}\n";
//     }
// }

// quit(999);


dd($photosObject[0]);

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




} // End class Controller

    // $timestamp_field = 'OPENDATE';
    // $query = "({$timestamp_field}=2000-01-01T00:00:00+)";
    // $query =  "(SUBAREA=0219)";
    // $query =  "(COUNTY=Bergen)";

    // $field = 'STREET';
    // $field_value = 'Grove';
    // $query = "({$field}=$field_value )";
    // $query =  "(STATEID=NJ)";


    // $config ->setLoginUrl('https://rets2.gsmls.com/rets_idx/login.do')
    //         ->setUsername('JosephKinsley')
    //         ->setPassword('27NWLFEFICES')
    //         ->setUserAgent('JosephKinsley/1.0')
    //         ->setUserAgentPassword('NF3U4ZUZ')
    //         ->setRetsVersion('1.8')
    //         ->setHttpAuthenticationMethod('digest');
