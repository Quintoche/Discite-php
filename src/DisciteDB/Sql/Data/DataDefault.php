<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataDefault
{
    private static $quote = "'";

    public static function escape(mixed $value, mysqli $connection)
    {
        DataInjection::escape($value,$connection);
        return self::$quote.addslashes($value).self::$quote;
    }
}

?>