<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataNull
{
    public static function test(mixed $value) : bool
    {
        return (is_null($value));
    }
    
    public static function escape(mixed $value, mysqli $connection)
    {
        return (string) 'NULL';
    }
}

?>