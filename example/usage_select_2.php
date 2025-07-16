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

    $disciteDB->loadFromFile(dirname(__DIR__, 2).'/discite-php/.files/sql.cache.json',0);

    $disciteDB->setEnvironment(1);

    $queryFakeItems = $disciteDB->table('materialMovementData')->update(['id'=>1],[
            'quantityGave'=>3,
    ]);

    // QUERY -- SELECT
    // $queryFakeItems = $disciteDB->table('vehicleMovementData_scope')->listing(['foreignCategory'=>7,'foreignCategoryPrincipal'=>QueryCondition::Or(null, 1),'foreignCategorySecondary'=>QueryCondition::Or(null, 1)]);
    // $queryFakeItems = $disciteDB->table('vehicleControlData_scope')->listing(['foreignCategory'=>4,'foreignCategoryPrincipal'=>QueryCondition::Or(null, 1),'foreignCategorySecondary'=>QueryCondition::Or(null, 2),'foreignExceptPrimary'=>QueryCondition::Or(null,QueryCondition::Not(1)),'foreignExceptSecondary'=>QueryCondition::Or(null,QueryCondition::Not(2))]);
    // $queryFakeItems = $disciteDB->table('vehicle')->update(['id'=>7],['mileage'=>10]);

    // After that, you can show values :

    // You will get only informations but no values
    echo '<br/><br/><br/><br/><b>QUERY</b>';
    // echo '<pre>',var_dump($queryFakeItems->fetchQuery()),'</pre>';


    // You will get only informations but no values
    echo '<b>INFORMATIONS ONLY</b>';
    // echo '<pre>',var_dump($queryFakeItems->fetchInformations()),'</pre>';
    
    // You will have the next data
    echo '<b>NEXT DATA</b>';
    // echo '<pre>',var_dump($queryFakeItems->fetchNext()),'</pre>';
    
    // You will have all data
    echo '<b>ALL DATA</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchAll()),'</pre>';
    
    // You will have all data and infos
    echo '<b>ALL DATA AND INFORMATIONS</b>';
    // echo '<pre>',var_dump($queryFakeItems->fetchArray()),'</pre>';
    
?>