<?php

date_default_timezone_set('America/New_York');

require_once("vendor/autoload.php");

$config = new \PHRETS\Configuration;
$config->setLoginUrl('rets login url here')
        ->setUsername('rets username here')
        ->setPassword('rets password here')
        ->setRetsVersion('1.7.2');

$rets = new \PHRETS\Session($config);

// If you're using Monolog already for logging, you can pass that logging instance to PHRETS for some additional
// insight into what PHRETS is doing.
//
// $log = new \Monolog\Logger('PHRETS');
// $log->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG));
// $rets->setLogger($log);

$connect = $rets->Login();

$system = $rets->GetSystemMetadata();
var_dump($system);

$resources = $system->getResources();
$classes = $resources->first()->getClasses();
var_dump($classes);

$classes = $rets->GetClassesMetadata('Property');
var_dump($classes->first());

$objects = $rets->GetObject('Property', 'Photo', '00-1669', '*', 1);
var_dump($objects);

$fields = $rets->GetTableMetadata('Property', 'A');
var_dump($fields[0]);

$results = $rets->Search('Property', 'A', '*', ['Limit' => 3, 'Select' => 'LIST_1,LIST_105,LIST_15,LIST_22,LIST_87,LIST_133,LIST_134']);
foreach ($results as $r) {
    var_dump($r);
}