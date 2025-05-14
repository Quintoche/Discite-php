<?php

namespace DisciteDB\Sql\Data;

class DataDatabase
{
    private static $quote = '`';

    public static function escape(mixed $database) : ?string
    {
        if(is_null($database)) return null; 
        return self::$quote.$database.self::$quote;
    }
}

?>