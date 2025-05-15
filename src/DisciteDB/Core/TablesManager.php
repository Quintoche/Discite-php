<?php
namespace DisciteDB\Core;

use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Tables\CustomTable;

class TablesManager
{
    private Database $database;

    protected array $map = [];

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function create(string $tableName, ?array $parms = []) : BaseTable
    {
        $class = new CustomTable($this->database);
        
        $class->setMagicValue('name',$tableName);
        foreach($parms as $k => $v)
        {
            $class->setMagicValue($k,$v);
        }

        $tableAlias = $parms['alias'] ?? $tableName;
        $class->setMagicValue('alias',$tableAlias);
        $this->registerTable($tableAlias,$class);
        return $class;
    }

    public function update(string $tableName, ?array $parms = []) : void
    {
        $class = $this->returnClassInMap($tableName);

        foreach($parms as $k => $v)
        {
            $class->setMagicValue($k,$v);
        }

        $tableAlias = $class->getAlias() ?? $parms['alias'] ?? $tableName;
        
        $this->registerTable($tableAlias,$class);
    }   

    public function delete(string $tableName) : void
    {
        $class = $this->returnClassInMap($tableName);
        unset($class);
    }

    public function appendKey(string $tableName, BaseKey ...$keys) : void
    {
        $class = $this->returnClassInMap($tableName);
        
        foreach($keys as $key)
        {
            $class->appendKey($key);
        }
    }

    public function revokeKey(string $tableName, BaseKey ...$keys) : void
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

    /**
     * Récupère une instance de table à partir de son nom ou alias.
     *
     * @param string $name Nom ou alias de la table
     * @return CustomTable
     */
    public function getTable(string $name) : CustomTable
    {
        return $this->returnClassInMap($name);
    }
    public function getTables() : array
    {
        return $this->map;
    }

    private function registerTable(string $tableAlias, BaseTable $tableClass) : void
    {
        $this->map[$tableAlias] = $tableClass;
    }

    private function returnClassInMap(string $className) : null|BaseTable
    {
        $table = $this->map[$className] ?? null;
        if(!$table) throw new \Exception("Table '$className' not found");

        return $table;
            
    }
}

?>