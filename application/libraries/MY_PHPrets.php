<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_PHPrets extends MX_Controller {
 
private $debug = 1;

function __construct(){
    parent::__construct();

    // $this->output->enable_profiler(true);

}

public function index(){
    // echo "<h1>MLS Data</h1>";
}

 
public function connect_mls($LoginUrl, $Username, $Password)
{
    // setup your configuration
    $config = new \PHRETS\Configuration;
    $config ->setLoginUrl($LoginUrl)
            ->setUsername($Username)
            ->setPassword($Password)
            ->setRetsVersion('1.5')
            ->setHttpAuthenticationMethod('basic');

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
    $this->benchmark->mark('search_start');   // Benchmark
    $results = $this->rets->Search(
        'Property',                    // resource
        strtoupper($ptype),            // class
        $query,
        ['Limit' => $limit, 'Format' => 'COMPACT-DECODED']
    );

    // return the total number of results found (reported by the RETS server)
    $MLS_Results['TotalResultsCount'] = $results->getTotalResultsCount(); // loop through results
    // return the count of results actually retrieved by PHRETS
    $MLS_Results['TotalCounts'] = $results->getReturnedResultsCount(); // same as: count($results)
    // return whether or not the RETS server has more results to give
    $MLS_Results['isMaxRowsReached'] = $results->isMaxRowsReached() ? 'RETS server has more results to give' : 'Complete';
    $this->benchmark->mark('search_done');   // Benchmark

    $timestamp = convert_timestamp( time(), 'full');
    $txt  = PHP_EOL."==============================================".PHP_EOL.$table_name.PHP_EOL;
    $txt .= 'Date: '.$timestamp.PHP_EOL;
    $txt .= 'Note: '.$MLS_Results['isMaxRowsReached'].PHP_EOL;
    $txt .= 'TotalResultsCount | '.$MLS_Results['TotalResultsCount'].PHP_EOL;
    $txt .= 'Actual retrieved results | '.count($results).PHP_EOL;
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
// dd($mysql_listing,1);

        $Matched_removed = 0;
        $Process_remaining = 0;        

        // results is array from MLS query
        foreach ($results as $key => $r) {
            /* Get mls property listing ID number */
            $mls_listing = $r->get('LISTINGID');

            /* Check $mls_listing array remove if LISTINGID. */
            $process_complete = true;            
            if( $mysql_listing[$mls_listing] ){
                $Matched_removed++;    
                unset($mysql_listing[$mls_listing]); // remove from data array     
                unset($results[$key]); // remove from results- $key is record id number;
            } else {
                $Process_remaining++;    
                // if( $Process_remaining > 50 ) {
                //     unset($mysql_listing[$mls_listing]); // remove from data array     
                //     unset($results[$key]); // remove from results- $key is record id number ;                 
                //     $process_complete = false;
                // }
            }
        }

        /* Remove remaining $mysql_listing from mysql table */
        $Remove_records_not_needed = 0;       
        if( count($mysql_listing)>0) {
            $Remove_records_not_needed =
                 $this->model_name->delete_listings('id', $mysql_listing, $table_name);
        }

    } else {
        $Process_remaining = count($results);    
    }
    $this->benchmark->mark('deDupe_done');   // Benchmark

    $txt  = "Matched: ".$Matched_removed."  | Removed: ".count($mysql_listing)."    Removed from Database: ".$Remove_records_not_needed.PHP_EOL;
    $txt .= "New Records: ".$Process_remaining." | Processed and added: ".count($results)." record(s)        Total Elapsed Time : ".$this->benchmark->elapsed_time('deDupe_start', 'deDupe_done').PHP_EOL."----------------------------------------".PHP_EOL.PHP_EOL;

    /* record benchmarks to log */
    $this->write_log($txt, null);


    // Assing photo urls to results
    $this->benchmark->mark('photo_start');   // Benchmark
    $photo_array = [];    
    $TotalCounts = count($results);

    if( $get_photo_data && count($results) > 0 ) {
        $photo_array = $this->_build_array($results, $TotalCounts );
    }

    $x = 0;
    foreach ($results as $r) {
        $r['latX'] = '';
        $r['longY']= '';
        $r['address']= '';  
        $r['source'] = $ptype;
        // set picture
        $r['photos'] = $photo_array[$r->get('LISTINGID')];
        $x++;
    }
    $this->benchmark->mark('photo_done');   // Benchmark

    $status = $get_photo_data ? '[On]  ' : '[Off]  ';
    $txt  = "Photo total: ".$status.count($results)." Total Elapsed Time : ".$this->benchmark->elapsed_time('photo_start', 'photo_done').PHP_EOL."----------------------------------------".PHP_EOL;
    /* record benchmarks to log */
    $this->write_log($txt, null);

    $mls_msql = $results->toArray();
    unset($results);
    unset($MLS_Results);

    return [$mls_msql, $process_complete ];
}

private function _build_array(&$results, $TotalCounts)
{
    $x = 1;
    $number_passes = 1;   
    $batch_count = 400;    // max is 525
    $total_sets = ceil($TotalCounts/$batch_count);
    $last_batch_count = $TotalCounts - ( floor($TotalCounts/$batch_count) * $batch_count );

    $sub_total = 0;
    foreach ($results as $key => $value) {
        // set_time_limit(300);   
    // ddf("Execution Time = ".(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),1);        
    // quit(99);

        $listingId[$x] = $results[$key]->get('LISTINGID');

        /* Adjust batch_count for last pass thru */
        if($number_passes == $total_sets) {
            $batch_count = $last_batch_count > 0 ? $last_batch_count : $batch_count;
        };

        if( $x == $batch_count ){
            $number_passes++;

            $sub_total = $sub_total+$batch_count;
            $photosObject = $this->rets->GetObject("Property", "Photo", $listingId, "0", 1);

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

public function data_geocode(&$mls_msql)
{
    $geo_found   = 0;
    $get_geo_cnt = 0;
    $get_geo_added = 0;
    $data = [];
    $new_data = [];
    $incomplete = false;  

    // select all geocodes 
    $query = $this->model_name->get_all('geocodes');
    foreach ($query->result() as $key => $value)
        $geo_lookup[$value->listingid] = [ $value->latX, $value->longY,$value->address ];
    
    $x = 0;
    $loops = 0;    
    $total = 0;
    $pause = 400;

    foreach ($mls_msql as $key => $value) {
        $loops++;
        $address = $value['STREETNUM'].' '.$value['STREETDIR'].' '.$value['STREET'].' '.$value['STREETTYP'].' '.$value['AREANAME'].' '.$value['STATEID'];

        /* look up listingid in $geo_lookup ARRAY */
        $listingid = $mls_msql[$key]['LISTINGID'];

        if( $geo_lookup[$listingid] ){
            $geo_found++;
        } else {
            $get_geo_cnt++;            
            $geo_addon = $this->geocode($address);

            /* Add to geocode table */
            if($geo_addon){
                list( $data['latX'], $data['longY'], $data['address'] ) = $geo_addon;
                $data['listingid'] = $listingid;
                $new_data[] = $data;
                $get_geo_added++;
            }

            if( $x == 100) {
                $total = $total+$x;
                $x = 0;

                if( $this->debug ){
                    $txt = 'Geocode codes looked up.... '.$total.PHP_EOL;
                    /* record benchmarks to log */
                    $this->write_log($txt, null);
                }

                /* This break is to avoid php timeout on script and start loop */
                if($total > 200) {
                    if( $this->debug ){
                        $txt = 'Exit Geocode look up.... '.PHP_EOL;
                        /* record benchmarks to log */
                        $this->write_log($txt, null);
                    }
                    $incomplete = true;  
                    break;
                }
                if($total > $pause) sleep(2);
            }
            $x++;

        }
    } // end foreach

    if( count($new_data)>0 ) {
        $table_name = 'geocodes';
        $this->model_name->insert_new_geo($new_data, $table_name);        
    }

    $complete = $incomplete ? 'No': 'Yes';
    $txt = 'In house geocodes: '.$geo_found.' | Googled: '.$get_geo_cnt.' | Matched: '.$get_geo_added.' | Complete: '.$complete.' | Loops: '.$loops.PHP_EOL;
    /* record benchmarks to log */
    $this->write_log($txt, null);

    return $incomplete;
}


// function to geocode address, it will return false if unable to geocode address
private function geocode($address){
     // url encode the address
    $address = urlencode($address);

    // JKinsley original API -> AIzaSyAEC09lxdr8qESayOrXjiPDCvcAoa95LYI
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyAt059eRF2ThiE1WmyavE2x2mUOIUAW8xc";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
            /* put the data in the array - Originaly from google
               $data_arr = array();            
               array_push(
                 $data_arr, 
                     $lati, 
                     $longi, 
                     $formatted_address
                 );
             return $data_arr;
            */

            return [ $lati, $longi, $formatted_address];
             
        }else{
            // return false;  // Originaly from google
            return false; 
        }
         
    }
 
    else{
        // echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
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
