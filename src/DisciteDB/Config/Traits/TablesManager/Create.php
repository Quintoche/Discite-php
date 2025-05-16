<?php

namespace DisciteDB\Config\Traits\TablesManager;

use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\DisciteDB;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Tables\CustomTable;

trait Create
{
    public function create(string $tableName, ?array $parms = []) : BaseTable
    {
        $class = $this->createInitializeTable();
        
        $class->setMagicValue('name',$tableName);
        foreach($parms as $k => $v)
        {
            if($k == 'indexKey')
            {
                $class->setIndexKey($this->createGetKey($v));
                continue;
            }
            $class->setMagicValue($k,$v);
        }

        $class->setMagicValue('alias',$this->createSelectName($tableName,$parms['alias']));
        $this->createAppendTable($this->createSelectName($tableName,$parms['alias']),$class);
        return $class;
    }

    public function add(string $name, ?string $alias = null, ?string $prefix = null, BaseKey|string|null $indexKey = null, ?QuerySort $sort = DisciteDB::SORT_NO_SORT) : BaseTable
    {
        $class = $this->createInitializeTable();

        $class->setName($name);
        if($alias) $class->setAlias($alias);
        if($prefix) $class->setPrefix($prefix);

        if($indexKey)
        {
            $class->setIndexKey($this->createGetKey($indexKey));
        } 
        
        $class->setSort($sort);

        $this->createAppendTable($this->createSelectName($name,$alias),$class);

        return $class;
    }

    protected function createInitializeTable()
    {
        return new CustomTable($this->database);
    }

    protected function createGetKey(BaseKey|string|null $key = null) : BaseKey
    {
        return match (true) {
            $key instanceof BaseKey => $key,
            $this->database->keys()->$key => $this->database->keys()->$key,
            default => $this->createDefaultKey($key),
        };
    }

    protected function createDefaultKey(string $keyName) : BaseKey
    {
        return $this->database->keys()->create($keyName);
    }

    protected function createSelectName(?string $tableName, ?string $tableAlias) : string
    {
        return $tableAlias ?? $tableName;
    }

    protected function createAppendTable(string $selectedName, BaseTable $class) : void
    {
        $this->registerTable($selectedName, $class);
    }
}

?>