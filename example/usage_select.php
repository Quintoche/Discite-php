<?php

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\DisciteDB;
use DisciteDB\Methods\QueryCondition;
use DisciteDB\Methods\QueryMethod;
use DisciteDB\Methods\QueryModifier;

ini_set('display_errors','1');
ini_set('display_startup_erros','1');
error_reporting(E_ALL);


    require 'default_file.php';


    // Create your connection
    $_connection = new mysqli('localhost','root','','disciteRemiseV2');


    // Initiate DisciteDB Manager
    // Put as argument the connection you've initiate 
    $disciteDB = new \DisciteDB\Database($_connection);

    // Make your configuration
    // You acn choose between alias
    // Configuration is not defined and explained here
    $disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
    $disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);

    // To show how to make "SELECT" query, I've prefere to make loose usage for 
    // both table and keys.

    $disciteDB->config()->setNamingConvention(DisciteDB::NAMING_CONVENTION_UNDEFINED);

    $disciteDB->loadFromDatabase();

    $disciteDB->setEnvironment(1);

    // QUERY -- SELECT
    $queryFakeItems = $disciteDB->table('vehicleBooking')->listing([
        'foreignVehicle'=>7
    ]);

    // After that, you can show values :

    // You will get only informations but no values
    echo '<br/><br/><br/><br/><b>QUERY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchQuery()),'</pre>';


    // You will get only informations but no values
    echo '<b>INFORMATIONS ONLY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchInformations()),'</pre>';
    
    // You will have the next data
    echo '<b>NEXT DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchNext()),'</pre>';
    
    // You will have all data
    echo '<b>ALL DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchAll()),'</pre>';
    
    // You will have all data and infos
    echo '<b>ALL DATA AND INFORMATIONS</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchArray()),'</pre>';
    
?>