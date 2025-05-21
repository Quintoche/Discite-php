<?php

namespace DisciteDB\Sql\Loading;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Sql\Data\DataValue;
use mysqli;

class LoadingQuery
{
    protected static string $query = "SELECT c.TABLE_NAME, c.COLUMN_NAME, c.DATA_TYPE, c.COLUMN_KEY, c.COLUMN_DEFAULT, c.IS_NULLABLE, c.CHARACTER_MAXIMUM_LENGTH, c.EXTRA, s.NON_UNIQUE, s.INDEX_TYPE, k.CONSTRAINT_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS c LEFT JOIN INFORMATION_SCHEMA.STATISTICS s ON c.TABLE_SCHEMA = s.TABLE_SCHEMA AND c.TABLE_NAME = s.TABLE_NAME AND c.COLUMN_NAME = s.COLUMN_NAME LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE k ON c.TABLE_SCHEMA = k.TABLE_SCHEMA AND c.TABLE_NAME = k.TABLE_NAME AND c.COLUMN_NAME = k.COLUMN_NAME WHERE c.TABLE_SCHEMA = {DATABASE}";

    public static function makeQuery(mysqli $connection) : array
    {
        return self::returnArray(self::performQuery(self::searchReplace(self::$query,['DATABASE'=>self::returnDatabase($connection)]),$connection));
    }


    private static function returnArray(array $queryResult) : array
    {
        $schema = [];

        foreach ($queryResult as $row) {
            $table = $row['TABLE_NAME'];
            $column = $row['COLUMN_NAME'];

            if (!isset($schema[$table])) {
                $schema[$table] = [
                    'name' => $table,
                    'columns' => []
                ];
            }

            $schema[$table]['columns'][$column] = [
                'table' => $table,
                'name' => $row['COLUMN_NAME'],
                'type' => $row['DATA_TYPE'],
                'key' => $row['COLUMN_KEY'],
                'default' => $row['COLUMN_DEFAULT'],
                'nullable' => $row['IS_NULLABLE'],
                'length' => $row['CHARACTER_MAXIMUM_LENGTH'],
                'extra' => $row['EXTRA'],
                'index' => [
                    'non_unique' => $row['NON_UNIQUE'],
                    'index_type' => $row['INDEX_TYPE'],
                    'constraint_name' => $row['CONSTRAINT_NAME'],
                    'referenced_table' => $row['REFERENCED_TABLE_NAME'],
                    'referenced_column' => $row['REFERENCED_COLUMN_NAME'],
                ]
            ];
        }


        return $schema;
    }

    private static function performQuery(string $query, mysqli $connection) : array
    {
        return mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
    }

    private static function returnDatabase(mysqli $connection) : ?string
    {
        return DataValue::escape(ConnectionConfig::$DATABASE, $connection);
    }

    private static function searchReplace(string $haystack, array|string $needle) : string
    {
        if(is_array($needle))
        {
            foreach($needle as $search => $replace)
            {
                $haystack = str_replace('{'.$search.'}',$replace,$haystack);
            }
            return $haystack;
        }
        else
        {
            return $haystack;
        }
    }

}

?>