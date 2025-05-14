<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataInjection
{
    public static function escape(mixed &$value, mysqli $connection)
    {
        $value = mysqli_escape_string($connection, $value);
    }
}

?>