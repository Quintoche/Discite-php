<?php

namespace DisciteDB\Config\Traits\TablesManager;

use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\DisciteDB;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Tables\BaseTable;

trait Update
{
    public function update(BaseTable|string $tableName, ?array $parms = []) : void
    {
        $class = $this->updateGetTable($tableName);

        foreach($parms as $k => $v)
        {
            $class->setMagicValue($k,$v);
        }
        
        $this->createAppendTable($this->updateSelectName($tableName,$parms['alias']),$class);
    } 

    public function modify(BaseTable|string $tableName, ?string $alias = null, ?string $prefix = null, BaseKey|string|null $indexKey = null, ?QuerySort $sort = DisciteDB::SORT_NO_SORT) : BaseTable
    {
        $class = $this->updateGetTable($tableName);

        $class->setName($tableName);
        if($alias) $class->setAlias($alias);
        if($prefix) $class->setPrefix($prefix);

        if($indexKey)
        {
            $class->setIndexKey($this->updateGetKey($indexKey));
        } 
        
        $class->setSort($sort);

        $this->updateAppendTable($this->updateelectName($tableName,$alias),$class);

        return $class;
    }

    protected function updateGetKey(BaseKey|string|null $key = null) : BaseKey
    {
        return match (true) {
            $key instanceof BaseKey => $key,
            $this->database->keys()->$key => $this->database->keys()->$key,
            default => $this->updateDefaultKey($key),
        };
    }

    protected function updateDefaultKey(string $keyName) : BaseKey
    {
        return $this->database->keys()->create($keyName);
    }

    protected function updateGetTable(BaseTable|string $table) : BaseTable
    {
        return match (true) {
            $table instanceof BaseTable => $table,
            $this->database->tables()->$table => $this->database->tables()->$table,
            default => $this->updateDefaultTable($table),
        };
    }

    protected function updateDefaultTable(string $tableName) : BaseTable
    {
        return $this->database->tables()->create($tableName);
    }

    protected function updateSelectName(?string $tableName, ?string $tableAlias) : string
    {
        return $tableAlias ?? $tableName;
    }

    protected function updateAppendTable(string $selectedName, BaseTable $class) : void
    {
        $this->registerTable($selectedName, $class);
    }
}

?>