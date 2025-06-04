<?php

use DisciteDB\DisciteDB;

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

    // To show how to make "SELECT" query, I've prefere to make loose usage for 
    // both table and keys.

    $disciteDB->config()->setNamingConvention(DisciteDB::NAMING_CONVENTION_UNDEFINED);

    $start = microtime(true);
    // QUERY -- LOAD
    $disciteDB->loadFromFile(dirname(__DIR__, 2).'/discite-php/.files/sql.cache.json',0);

    $end = microtime(true);
    $duration = ($end - $start) * 1000;

    $_rows = [];

    foreach($disciteDB->debug()->showTables() as $table)
    {
        $_rows[] = count($table['keys']);
    }

    // After that, you can show values with debug:

    echo '<br/><br/><br/><b>TIME LOAD TABLES AND KEYS</b>';
    echo '<pre>Execution time: '. number_format($duration, 3, '.', ' ') .' ms</pre>';

    echo '<br/><br/><br/><b>DATAS</b>';
    echo '<br/><pre> TABLES : ',count($disciteDB->debug()->showTables()),'</pre>';
    echo '<br/><pre> KEYS : ',array_sum($_rows),'</pre>';

    echo '<br/><br/><br/><b>RETURN DEBUG</b>';
    echo '<pre>',var_dump($disciteDB->debug()->showTables()),'</pre>';
?>