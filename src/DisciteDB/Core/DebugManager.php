<?php

namespace DisciteDB\Core;

use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Tables\BaseTable;

class DebugManager
{
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }


    public function showTables() : array
    {
        $_tables = $this->getTables();
        $_array = [];

        foreach($_tables as $tableName => $tableClass)
        {
            $_array[] = $this->infoTable($this->getTable($tableName));
        }

        return $_array;
    }

    public function showKeys(?array $map)
    {
        if(empty($map)) return [];

        $_keys = $map;
        $_array = [];

        foreach($_keys as $keyName => $tableClass)
        {
            $_array[] = $this->infoKey($tableClass);
        }

        return $_array;
    }

    private function getTables() : array
    {
        return $this->database->tables()->getTables();
    }
    private function getTable(string $tableName) : ?BaseTable
    {
        return $this->getTables()[$tableName];
    }
    private function infoTable(BaseTable $table) : ?array
    {
        return [
            'name' => $table->getName(),
            'alias' => $table->getAlias(),
            'prefix' => $table->getPrefix(),
            'primaryKey' => 'PrimaryKey :: '.$table->getPrimaryKey()->getName(),
            'sort' => 'SortingMethod :: '.$table->getSort()->name,
            'keys' => $this->showKeys($table->getMap()),
        ];
    }
    private function infoKey(BaseKey $key) : ?array
    {
        return [
            'name' => $key->getName(),
            'alias' => $key->getAlias(),
            'prefix' => $key->getPrefix(),
            'type' => 'Type :: '.$key->getType()->name,
            'index' => 'Index :: '.$key->getIndex()->name,
            'indexTable' => ($key->getIndexTable() instanceof BaseTable) ? 'IndexTable :: '.$key->getIndexTable()->getName() : null,
            'default' => ($key->getDefault() instanceof DefaultValue) ? 'DefaultValue :: '.$key->getDefault()->name : $key->getDefault(),
            'nullable' => $key->getNullable(),
            'secure' => $key->getSecure(),
            'updatable' => $key->getUpdatable(),
            'losseUsage' => $key->getLooseUsage(),
        ];
    }
}

?>