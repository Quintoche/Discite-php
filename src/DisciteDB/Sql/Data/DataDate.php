<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataDate
{
    private static $quote = "'";

    public static function test(mixed $value) : bool
    {
        return (bool) strtotime($value);
    }
    
    public static function escape(mixed $value, mysqli $connection) : string
    {
        DataInjection::escape($value,$connection);
        return self::$quote.addslashes($value).self::$quote;
    }
}

?>