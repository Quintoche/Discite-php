<?php

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryMethod;

ini_set('display_errors','1');
ini_set('display_startup_erros','1');
error_reporting(E_ALL);


    require 'default_file.php';
    
    $start = microtime(true);

    // Create your connection
    $_connection = new mysqli('localhost','root','','DisciteRemiseV2');


    // Initiate DisciteDB Manager
    // Put as argument the connection you've initiate 
    $disciteDB = new \DisciteDB\Database($_connection);

    // Make your configuration
    // You acn choose between alias
    // Configuration is not defined and explained here
    $disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
    $disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);

    $disciteDB->loadFromFile(dirname(__DIR__, 2).'/discite-php/.files/sql.cache.json',0);

    $disciteDB->setEnvironment(1);

    // QUERY -- RETRIEVE
    $queryFakeItems = $disciteDB->table('userAccount')->retrieve(1);
    

    $end = microtime(true);
    $duration = ($end - $start) * 1000;

    echo '<br/><br/><br/><b>TIME LOAD TABLES AND KEYS</b>';
    echo '<pre>Execution time: '. number_format($duration, 3, '.', ' ') .' ms</pre>';

    // After that, you can show values :

    // You will get only informations but no values
    echo '<br/><br/><br/><br/><b>QUERY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchQuery()),'</pre>';


    // You will get only informations but no values
    echo '<b>INFORMATIONS ONLY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchInformations()),'</pre>';
    
    // You will have all data
    echo '<b>ALL DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchArray()),'</pre>';
    
    
    
?> 