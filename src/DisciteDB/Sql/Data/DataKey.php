<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataKey
{
    private static $quote = '`';

    public static function escape(mixed $key, mysqli $connection) : string
    {
        DataInjection::escape($key,$connection);
        return self::$quote.$key.self::$quote;
    }
}

?>