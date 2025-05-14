<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataTable
{
    private static $quote = '`';

    public static function escape(mixed $table) : ?string
    {
        if(is_null($table)) return null; 
        return self::$quote.$table.self::$quote;
    }
}

?>