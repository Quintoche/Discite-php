<?php

namespace DisciteDB\Sql\Clause;

use DisciteDB\Database;
use DisciteDB\Tables\BaseTable;

class ClauseKey
{
    // public static function has(?array $args) : bool
    // {
    //     return (bool) array_filter((array) $args, fn($v) => $v instanceof QueryMethodExpression);
    // }


    public static function getKeysFromTable(BaseTable|string $table, Database $database) : ?array
    {
        return match (true) {
            is_string($table) => $database->tables()->getTable($table)->getMap(),
            $table instanceof BaseTable => $table->getMap(),
            default => [],
        };
    }
}

?>