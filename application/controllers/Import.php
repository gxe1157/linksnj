<?php
 // set your timezone
date_default_timezone_set('America/New_York');

// pull in the packages managed by Composer
require_once("vendor/autoload.php");

// setup your configuration
$config = new \PHRETS\Configuration;
$config->setLoginUrl('http://rets-njmls.xmlsweb.com/rets/login')
        ->setUsername('MARC STEIN-RETS3')
        ->setPassword('UIAQZM')
        ->setRetsVersion('1.5')
        ->setHttpAuthenticationMethod('basic');

// get a session ready using the configuration
$rets = new \PHRETS\Session($config);

// log onto RETS NJ MLS
$connect = $rets->Login(); 

// search query
$results = $rets->Search(
        'Property',
        'RES',
        'AREA=7',
        ['Limit' => '10', 'Format' => 'COMPACT-DECODED']
    );
    
    // loop through results
    foreach ($results as $r) {
        
        // create temp array to append to our object
        $array = [];
        
        // grab all photo objects
        $photosObject = $rets->GetObject("Property", "Photo", $r->get('LISTINGID'), "*", 1);
        foreach ($photosObject as $photo) {
             // push each url onto the temp array
             array_push($array, $photo->getLocation());
        }

        // set the array of pics
        $r['photos'] = $array;
    }

    // dump results as JSON
    echo $results->toJSON();
    
    // d/c our session
    $rets->Disconnect();
?>