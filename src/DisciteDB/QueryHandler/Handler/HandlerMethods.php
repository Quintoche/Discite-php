<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Database;
use DisciteDB\Sql\Clause\ClauseTable;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataTable;
use DisciteDB\Tables\BaseTable;
use mysqli;

class HandlerMethods
{
    protected BaseTable $table;

    protected Database $database;

    protected mysqli $connection;

    protected ?array $argumentArray;

    protected ?array $indexKey;

    protected ?array $foreignTable = [];

    protected ?array $foreignKey;

    protected ?array $currentTable;

    protected ?array $currentKey;

    protected ?array $multiArray;
    
    public function __construct(BaseTable $table, Database $database, mysqli $connection)
    {
        $this->table = $table;

        $this->database = $database;

        $this->connection = $connection;

        if(!$this->tableHasIndexKey($this->table)) return;

        $this->indexKey = $this->getIndexKey($this->table);

        $this->multiArray = $this->getForeign($this->indexKey, $this->table);

        $this->createArgs();
    }

    public function retrieve() : ?array
    {
        if ($this->database->config()->getTableUsage() == TableUsage::LooseUsage) return [];
        if ($this->database->config()->getKeyUsage() == KeyUsage::LooseUsage) return [];

        return $this->argumentArray ?? ['COUNT' => 0];
    }

    public function retrieveForeign()
    {   
        return $this->multiArray;
    }

    private function tableHasIndexKey(BaseTable $table) : bool
    {
        return ClauseTable::hasIndexKey($table,$this->database);
    }

    private function getIndexKey(BaseTable $table) : ?array
    {
        return ClauseTable::getIndexKey($table,$this->database);
    }

    private function getForeign(array $indexKeys, BaseTable $table) : array
    {
        $_array = [];
        $_array[$table->getAlias() ?? $table->getName()] = [];

        foreach($table->getMap() as $keys)
        {
            if($keys->getIndex() == IndexType::Index) continue;
            $_array[$table->getAlias() ?? $table->getName()][] = $keys->getAlias();
        }
            

        foreach($indexKeys as $i => $key)
        {
            if(!$key->getIndexTable()) {$this->removeIndexKey($i); continue;}

            $_foreignTable = $key->getIndexTable();
            $_foreignKey = $_foreignTable->getPrimaryKey() ?? null;

            if(!$_foreignKey){ $this->removeIndexKey($i); continue;}
            
            $foreignTable = $_foreignTable->getAlias() ?? $_foreignTable->getName();

            
            $this->foreignKey[] = $this->escapeKey($_foreignKey->getAlias()) ?? $this->escapeKey($_foreignKey->getName());
            
            
            $this->currentTable[] = $this->escapeTable($table->getAlias()) ?? $this->escapeTable($table->getName());
            $this->currentKey[] = $this->escapeKey($key->getAlias()) ?? $this->escapeKey($key->getName());

            if(in_array($foreignTable,$this->foreignTable)) continue;
            $this->foreignTable[] = $_foreignTable->getAlias() ?? $_foreignTable->getName();

            if(!$this->tableHasIndexKey($_foreignTable)) continue;

            $_array[$table->getAlias() ?? $table->getName()][] = $this->getForeign($this->getIndexKey($_foreignTable),$_foreignTable);
        }

        return $_array;
    }
    
    private function escapeKey(string $key) : string
    {
        return DataKey::escape($key,$this->connection);
    }
    
    private function escapeTable(?string $table) : ?string
    {
        if(!$table) return null;
        return DataTable::escape($table,$this->connection);
    }

    private function createArgs()
    {
        $this->argumentArray = [
            'COUNT' => count($this->foreignTable),
            'TABLE' => $this->currentTable,
            'INDEX_KEY' => $this->currentKey,
            'TABLE_FOREIGN' => $this->foreignTable,
            'FOREIGN_PRIMARY_KEY' => $this->foreignKey
        ];
    }

    private function removeIndexKey(int $index) : void
    {
        unset($this->indexKey[$index]);
    }
    
}

?>