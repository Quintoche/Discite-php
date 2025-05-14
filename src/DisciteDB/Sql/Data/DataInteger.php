<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataInteger
{
    public static function test(mixed $value) : bool
    {
        return (is_int($value) || is_float($value));
    }
    
    public static function escape(mixed $value, mysqli $connection) : string
    {
        DataInjection::escape($value,$connection);
        return (string) $value;
    }
}

?>