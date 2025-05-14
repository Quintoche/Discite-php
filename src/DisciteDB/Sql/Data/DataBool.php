<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataBool
{
    public static function test(mixed $value) : bool
    {
        return (is_bool($value));
    }
    
    public static function escape(mixed $value, mysqli $connection)  : string
    {
        DataInjection::escape($value,$connection);
        return (string) $value ? '1' : '0';
    }
}

?>