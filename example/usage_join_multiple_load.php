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
    $_connection = new mysqli('localhost','root','','discite_remise');


    // Initiate DisciteDB Manager
    // Put as argument the connection you've initiate 
    $disciteDB = new \DisciteDB\Database($_connection);

    // Make your configuration
    // You acn choose between alias
    // Configuration is not defined and explained here
    $disciteDB->configuration()->setCharset(DisciteDB::CHARSET_UTF8MB4);
    $disciteDB->config()->setCollation(DisciteDB::COLLATION_UTF8MB4_UNICODE_CI);

    // For a auto joining methods, you'll have to put strict usage for table and keys.
    $disciteDB->conf()->setTableUsage(DisciteDB::TABLE_USAGE_STRICT);
    $disciteDB->conf()->setKeyusage(DisciteDB::KEY_USAGE_STRICT);

    $disciteDB->config()->setNamingConvention(DisciteDB::NAMING_CONVENTION_UNDEFINED);


    $disciteDB->loadFromFile(dirname(__DIR__, 2).'/discite-php/.files/sql.cache.json',strtotime('+3 hours'));


    $start = microtime(true);
    // QUERY -- SELECT
    $queryFakeItems = $disciteDB->table('disc_account')->listing([
        'token' => QueryCondition::Not('test'),
    ]);

    $end = microtime(true);
    $duration = ($end - $start) * 1000;

    // After that, you can show values :

    // You will get only informations but no values
    echo '<br/><br/><br/><br/><b>QUERY</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchQuery()),'</pre>';
    
    // You will have all data and infos
    echo '<b>ALL DATA AND INFORMATIONS | Duration : '.number_format($duration, 3, '.', ' ').'ms</b>';
    echo '<pre>',var_dump($queryFakeItems->fetchNext()),'</pre>';
    echo '<pre>',var_dump($queryFakeItems->fetchNext()),'</pre>';
    
?>