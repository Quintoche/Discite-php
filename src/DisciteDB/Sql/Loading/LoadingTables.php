<?php

namespace DisciteDB\Sql\Loading;

use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Tables\BaseTable;

class LoadingTables
{
    public static function create(string $tableName, Database $database) : BaseTable
    {
        return $database->tables()->add($tableName);
    }

    public static function appendKeys(string $tableName, ?array $keys ,Database $database)
    {
        $database->tables()->appendKey($tableName,...$keys);
    }



    public static function addPrimaryKey(BaseTable $table, BaseKey $key)
    {
        $table->setPrimaryKey($key);
    }
}

?>