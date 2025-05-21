<?php

namespace DisciteDB\Sql\Clause;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Database;
use DisciteDB\Tables\BaseTable;

class ClauseTable
{
    public static function hasIndexKey(string|BaseTable $table, Database $database) : bool
    {
        $keys = ClauseKey::getKeysFromTable($table,$database);
        return (bool) array_filter((array) $keys, fn($v) => $v->getIndex() === IndexType::Index);
    }
    
    public static function getIndexKey(string|BaseTable $table, Database $database) : ?array
    {
        $keys = ClauseKey::getKeysFromTable($table,$database);
        return array_filter((array) $keys, fn($v) => $v->getIndex() === IndexType::Index);
    }
}

?>