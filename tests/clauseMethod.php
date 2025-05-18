<?php

ini_set('display_errors','1');
    ini_set('display_startup_erros','1');
    error_reporting(E_ALL);
    
    require dirname(__DIR__, 2).'/discite-php/vendor/autoload.php';

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Methods\QueryCondition;
use DisciteDB\Methods\QueryMethod;
use DisciteDB\Sql\Clause\ClauseMethod;

$array_1 = [
    'key' => 'value',
    'key_2' => 3,
    QueryCondition::Like('test',QueryLocation::Between),
];

$array_2 = [
    'key' => 'value',
    'key_2' => 3,
    QueryCondition::Like('test',QueryLocation::Between),
    QueryMethod::Async(null),
];

$array_3 = [
    'key' => 'value',
    QueryMethod::Async(null),
    'key_2' => 3,
    QueryCondition::Like('test',QueryLocation::Between),
];

var_dump(ClauseMethod::hasQueryMethod($array_1));
var_dump(ClauseMethod::hasQueryMethod($array_2));
var_dump(ClauseMethod::hasQueryMethod($array_3));
var_dump(ClauseMethod::hasQueryMethod([]));


?>