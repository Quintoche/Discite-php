<?php
namespace DisciteDB\Core;

use DisciteDB\Configuration;
use DisciteDB\Keys\Key;
use DisciteDB\Tables\Table;

class TablesManager
{
    private Configuration $configuration;

    protected array $map = [];

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    public function create(string $tableName, ?array $parms = []) : Table
    {
        $class = new Table();
        
        $class->updateVariable('name',$tableName);
        foreach($parms as $k => $v)
        {
            $class->updateVariable($k,$v);
        }

        $tableAlias = $parms['alias'] ?? $tableName;
        $class->updateVariable('alias',$tableAlias);
        $this->registerTable($tableAlias,$class);
        return $class;
    }

    public function update(string $tableName, ?array $parms = []) : void
    {
        $class = $this->returnClassInMap($tableName);

        foreach($parms as $k => $v)
        {
            $class->updateVariable($k,$v);
        }

        $tableAlias = $class->getAlias() ?? $parms['alias'] ?? $tableName;
        
        $this->registerTable($tableAlias,$class);
    }   

    public function delete(string $tableName) : void
    {
        $class = $this->returnClassInMap($tableName);
        unset($class);
    }

    public function appendKey(string $tableName, Key ...$keys) : void
    {
        $class = $this->returnClassInMap($tableName);
        
        foreach($keys as $key)
        {
            $class->appendKey($key);
        }
    }

    public function revokeKey(string $tableName, Key ...$keys) : void
    {
        $class = $this->returnClassInMap($tableName);

        foreach($keys as $key)
        {
            $class->revokeKey($key);
        }
    }

    public function loadExistingTables() : void
    {

    }

    public function getTable(string $name) : Table
    {
        return $this->returnClassInMap($name);
    }

    private function registerTable(string $tableAlias, Table $tableClass) : void
    {
        $this->map[$tableAlias] = $tableClass;
    }

    private function returnClassInMap(string $className) : null|Table
    {
        $table = $this->map[$className] ?? null;
        if(!$table) throw new \Exception("Table '$className' not found");

        return $table;
            
    }
}

?>