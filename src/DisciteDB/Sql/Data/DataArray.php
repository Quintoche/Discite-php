<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataArray
{
    private static $quote = "'";

    public static function test(mixed $value) : bool
    {
        return (is_array($value));
    }
    
    public static function escape(mixed $value, mysqli $connection) : string
    {
        DataInjection::escape($value,$connection);
        return self::$quote.json_encode($value).self::$quote;
    }
}

?>