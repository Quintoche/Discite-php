<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Core\QueryManager;
use DisciteDB\Sql\Clause\ClauseTable;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataTable;
use DisciteDB\Tables\BaseTable;

class HandlerMethods
{
    protected QueryManager $queryManager;

    protected ?array $argumentArray;

    protected ?array $indexKey;

    protected ?array $foreignTable = [];

    protected ?array $foreignAlias = [];

    protected ?array $foreignKey;

    protected ?array $currentTable;

    protected ?array $currentKey;

    private string $mainTable;

    protected ?array $multiArray = [];
    
    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->mainTable = $this->queryManager->getTable()->getName() ?? $this->queryManager->getTable()->getAlias();

        if(!$this->tableHasIndexKey($this->queryManager->getTable())) return;

        $this->indexKey = $this->getIndexKey($this->queryManager->getTable());

        $this->multiArray = $this->getForeign($this->indexKey, $this->queryManager->getTable());

        $this->createArgs();
    }

    public function retrieve() : ?array
    {
        if ($this->queryManager->getInstance()->config()->getTableUsage() == TableUsage::LooseUsage) return ['COUNT' => 0];
        if ($this->queryManager->getInstance()->config()->getKeyUsage() == KeyUsage::LooseUsage) return ['COUNT' => 0];

        if($this->queryManager->getOperator() == Operators::Count || $this->queryManager->getOperator() == Operators::CountAll) return ['COUNT' => 0];

        return $this->argumentArray ?? ['COUNT' => 0];
    }

    public function retrieveForeign() : ?array
    {   
        return $this->multiArray;
    }

    private function tableHasIndexKey(BaseTable $table) : bool
    {
        return ClauseTable::hasIndexKey($table,$this->queryManager->getInstance());
    }

    private function getIndexKey(BaseTable $table) : ?array
    {
        return ClauseTable::getIndexKey($table,$this->queryManager->getInstance());
    }

    private function hasIndexKey(BaseTable $mainTable, array $indexedKeys = []) : bool
    {
        foreach($indexedKeys as $key)
        {
            if($key->getIndexTable()->getName() == $mainTable->getName()) return true;   
        }

        return false;
    }


    private function getForeign(array $indexKeys, BaseTable $table, array $visited = [], string $path = '', ?string $parentAlias = null): array
{
    $result = [];
    $tableKey = $table->getAlias() ?? $table->getName();

    $hash = $path . '/' . $tableKey;
    if (in_array($hash, $visited)) return [];

    $visited[] = $hash;
    $result[$tableKey] = [];

    foreach ($table->getMap() as $key) {
        if ($key->getIndex() === IndexType::Index) continue;
        $result[$tableKey][] = $key->getAlias();
    }

    foreach ($indexKeys as $key) {
        $foreignTable = $key->getIndexTable();
        if (!$foreignTable) continue;

        $foreignPrimary = $foreignTable->getPrimaryKey();
        if (!$foreignPrimary) continue;

        $foreignKeyName = $foreignPrimary->getAlias() ?? $foreignPrimary->getName();
        $localKeyName = $key->getAlias() ?? $key->getName();
        $localTable = $table->getAlias() ?? $table->getName();
        $foreignBaseName = $foreignTable->getAlias() ?? $foreignTable->getName();

        $this->foreignKey[]   = $this->escapeKey($foreignKeyName);
        $this->currentKey[]   = $this->escapeKey($localKeyName);

        $leftSideTable = $parentAlias ? $parentAlias : $localTable;
        $this->currentTable[] = $this->escapeTable($leftSideTable);

        $fullAlias = $foreignBaseName;
        $count = 1;
        while (in_array($this->escapeTable($fullAlias), $this->foreignAlias)) {
            $count++;
            $fullAlias = $foreignBaseName . '$$_$_$$' . $count;
        }

        $this->foreignAlias[] = $this->escapeTable($fullAlias);
        $this->foreignTable[] = $this->escapeTable($foreignBaseName);

        $nested = $this->getForeign(
            $this->getIndexKey($foreignTable),
            $foreignTable,
            $visited,
            $hash,
        
            $fullAlias 
        );
        
        if (!empty($nested)) {
            
            $nestedTableKey = key($nested); 
        
            if (isset($nested[$nestedTableKey])) {
                $nested[$nestedTableKey]['_alias'] = $fullAlias; // $fullAlias contient 'userPerson_2'
            }
    
            $result[$tableKey][] = $nested;
        }
    }

    return $result;
}






private function generateAlias(string $base, string $via = '', int &$counter = 1): string
{
    $alias = $base;
    if ($via !== '') {
        $alias .= '_' . $via;
    }
    while (in_array($alias, $this->foreignAlias)) {
        $alias = $base . '_' . $via . '_' . $counter;
        $counter++;
    }
    $this->foreignAlias[] = $alias;
    return $alias;
}


private function getForeigns()
{
    $_array = [];

    $mainTable = $this->queryManager->getTable();
    $mainTableName = $mainTable->getName();

    foreach ($this->queryManager->getInstance()->tables()->getMap() as $table) {
        if ($table->getName() === $mainTableName) continue;
        if (!$this->hasIndexKey($mainTable, $this->getIndexKey($table))) continue;

        $tableKey = $table->getAlias() ?? $table->getName();
        $_array[$tableKey][] = $this->getForeign($this->getIndexKey($table), $table, [], '', $mainTableName);
    }

    return $_array;
}

    
    private function escapeKey(string $key) : string
    {
        return DataKey::escape($key,$this->queryManager->getConnection());
    }
    
    private function escapeTable(?string $table) : ?string
    {
        if(!$table) return null;
        return DataTable::escape($table,$this->queryManager->getConnection());
    }

    private function createArgs()
    {
        $this->argumentArray = [
            'COUNT' => count($this->foreignTable),
            'TABLE' => $this->currentTable,
            'INDEX_KEY' => $this->currentKey,
            'TABLE_FOREIGN' => $this->foreignTable,
            'TABLE_ALIAS' => $this->foreignAlias,
            'FOREIGN_PRIMARY_KEY' => $this->foreignKey
        ];
    }

    private function removeIndexKey(int $index) : void
    {
        unset($this->indexKey[$index]);
    }
    
}

?>