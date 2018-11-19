<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_PHPrets_gsml extends MX_Controller {
 
private $debug = 1;

function __construct(){
    parent::__construct();
    // $this->output->enable_profiler(true);

}
 
public function connect_mls($LoginUrl, $Username, $Password,
                            $RetsVersion=null,
                            $httpAuthenticationMethod=null,
                            $UserAgent=null,
                            $AgentPassword=null)
{

    // setup your configuration
    $config = new \PHRETS\Configuration;

    $config ->setLoginUrl('https://rets2.gsmls.com/rets_idx/login.do')
            ->setUsername('JosephKinsley')
            ->setPassword('27NWLFEFICES')
            ->setRetsVersion('1.8')
            ->setHttpAuthenticationMethod('digest')
            ->setUserAgent('JosephKinsley/1.0')
            ->setUserAgentPassword('NF3U4ZUZ');

    // get a session ready using the configuration
    $this->rets = new \PHRETS\Session($config);

    // log onto RETS NJ MLS
    $connect = $this->rets->Login(); 
    // echo $connect ? 'true' : 'false';

    return $this->rets;

}

public function disconnect_rets()
{
    $this->rets->Disconnect(); 
}

public function do_search($ptype, $query, $limit, $get_photo_data, $table_name)
{
    $get_listings = [];
    for ($i = 1; $i <= 50; $i++) {
        $query = 'COUNTYCODE='.$i;

        $this->benchmark->mark('search_start');   // Benchmark
        $results = $this->rets->Search(
            'Property',                           // resource
            strtoupper($ptype),                   // class
            $query,
            ['Limit' => $limit, 'Format' => 'COMPACT-DECODED']
        );

if( $i == '18') dd($results);

        /* Get mls property data */
        foreach ($results as $key => $r) {
            $get_listings[] = $r;
        }
    } // for loop

//dd($get_listings);
//3456790


    $timestamp = convert_timestamp( time(), 'full');
    $txt  = PHP_EOL."==============================================".PHP_EOL.$table_name.PHP_EOL;
    $txt .= 'Date: '.$timestamp.PHP_EOL;
    $txt .= 'TotalResultsCount | '.count($get_listings).PHP_EOL;
    $txt .= 'Search is Done: Total Elapsed Time : '.$this->benchmark->elapsed_time('search_start', 'search_done').PHP_EOL."----------------------------------------".PHP_EOL;

    /* record benchmarks to log */
    $this->write_log($txt, null);

    // Remove duplicate entries
    $this->benchmark->mark('deDupe_start');   // Benchmark
    if ( $this->db->table_exists($table_name)) {
        // Get listingid from database
        $query = $this->model_name->get_all($table_name)->result();
        foreach ($query as $key => $row) {  
            $mysql_listing[$row->listingid] = $row->id;
        }

        $Matched_removed = 0;
        $Process_remaining = 0;        

        // results is array from MLS query
        foreach ($get_listings as $key => $r) {
            /* Get mls property listing ID number */
            $mls_listing = $r->get('LISTINGID');

            /* Check $mls_listing array remove if LISTINGID. */
            $process_complete = true;            
            if( $mysql_listing[$mls_listing] ){
                $Matched_removed++;    
                unset($mysql_listing[$mls_listing]); // remove from data array     
                unset($get_listings[$key]); // remove from results- $key is record id number;
            } else {
                $Process_remaining++;    
                // if( $Process_remaining > 50 ) {
                //     unset($mysql_listing[$mls_listing]); // remove from data array     
                //     unset($get_listings[$key]); // remove from results- $key is record id number ;                 
                //     $process_complete = false;
                // }
            }
        }

        /* Remove remaining $mysql_listing from mysql table */
        $Remove_records_not_needed = 0;       
        if( count($mysql_listing)>0)
            $Remove_records_not_needed =
                 $this->model_name->delete_listings('id', $mysql_listing, $table_name);

    } else {
        $Process_remaining = count($get_listings);    
    }
    $this->benchmark->mark('deDupe_done');   // Benchmark

    $txt  = "Matched: ".$Matched_removed."  | Removed: ".count($mysql_listing)."    Removed from Database: ".$Remove_records_not_needed.PHP_EOL;
    $txt .= "New Records: ".$Process_remaining." | Processed and added: ".count($get_listings)." record(s)        Total Elapsed Time : ".$this->benchmark->elapsed_time('deDupe_start', 'deDupe_done').PHP_EOL."----------------------------------------".PHP_EOL.PHP_EOL;

    /* record benchmarks to log */
    $this->write_log($txt, null);


    // Assing photo urls to results
    $this->benchmark->mark('photo_start');   // Benchmark
    $photo_array = [];    
    $TotalCounts = count($get_listings);

    if( $get_photo_data && count($get_listings) > 0 ) {
        $photo_array = $this->_build_array($get_listings, $TotalCounts );
    }
dd($photo_array);

    $x = 0;
    foreach ($get_listings as $r) {
        $r['latX'] = $r->get('LATITUDE');
        $r['longY']= $r->get('LONGITUDE');
        $r['address']= $r->get('STREETNUMBER').' '.$r->get('STREETNAME').' '.$r->get('CITY').' NJ '.$r->get('POSTALCODE');   
        $r['source'] = $ptype;
        // set picture
        $r['photos'] = $photo_array[$r->get('LISTINGID')];
        $x++;
    }
    $this->benchmark->mark('photo_done');   // Benchmark

    $status = $get_photo_data ? '[On]  ' : '[Off]  ';
    $txt  = "Photo total: ".$status.count($get_listings)." Total Elapsed Time : ".$this->benchmark->elapsed_time('photo_start', 'photo_done').PHP_EOL."----------------------------------------".PHP_EOL;

    /* record benchmarks to log */
    $this->write_log($txt, null);

//'3456790'
dd($get_listings[0],1);
quit('Stop.......');
    return [$get_listings, $process_complete ];
}


private function _build_array(&$get_listings, $TotalCounts)
{
    $x = 1;
    $number_passes = 1;   
    $batch_count = 400;    // max is 525
    $total_sets = ceil($TotalCounts/$batch_count);
    $last_batch_count = $TotalCounts - ( floor($TotalCounts/$batch_count) * $batch_count );

    $sub_total = 0;
    foreach ($get_listings as $key => $value) {
    	$listingId[$x] = $get_listings[$key]->get('LISTINGID');

        /* Adjust batch_count for last pass thru */
        if($number_passes == $total_sets){
            $batch_count = $last_batch_count > 0 ? $last_batch_count : $batch_count;
        };

        if( $x == $batch_count ){
            $number_passes++;

            $sub_total = $sub_total+$batch_count;
dd($listingId,1);


            $photosObject = $this->rets->GetObject("Property", "Photo", $listingId, "0", 1);
dd($photosObject,1);
ddf('Quit...............');

            /* phprets proivdes getContentId() and getLocation() */
            foreach ($photosObject as $photo) {  
                $photo_array[$photo->getContentId()] = $photo->getLocation();
            }

            /* reset for next pass */
            unset($photosObject);
            unset($listingId);
            $x = 1;
            sleep(3);            
        } else {
            $x++;
        }
        
    }
    unset($photosObject);
    unset($listingId);

    return $photo_array;
}




function write_log($txt, $file_name = null) {
    $file_name = APPPATH.'logs/testFile.txt';
    if( !file_exists( $file_name ) ):
        $fh = fopen($file_name, "w") or die("Unable to open file!");
    else:
        $fh = fopen($file_name, 'a') or die("Unable to open file!");
    endif;

    fwrite($fh, $txt);
    fclose($fh);
}
 
} //
