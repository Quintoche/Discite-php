<?php

namespace DisciteDB\Sql\Data;

use mysqli;

class DataExpression
{
    public static function escape(mixed $value, mysqli $connection) : string
    {
        return match (true) 
        {
            DataNull::test($value) => DataNull::escape($value, $connection),
            DataBool::test($value) => DataBool::escape($value, $connection),
            DataInteger::test($value) => DataInteger::escape($value, $connection),
            DataDate::test($value) => DataDate::escape($value, $connection),
            DataArray::test($value) => DataArray::escape($value, $connection),
            default => DataValue::escape($value, $connection),
        };
        
        
        
    }
}

?>