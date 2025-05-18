<?php
namespace DisciteDB\Core;

use DisciteDB\Config\Traits\TablesManager\Create;
use DisciteDB\Config\Traits\TablesManager\Delete;
use DisciteDB\Config\Traits\TablesManager\Update;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\QueryHandler\QueryResult;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Tables\CustomTable;
use DisciteDB\Utilities\NameSanitizer;

class TablesManager
{
    use Create;
    use Update;
    use Delete;

    private Database $database;

    protected array $map = [];

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function appendKey(string $tableName, BaseKey|string ...$keys) : void
    {
        $class = $this->returnClassInMap($tableName);
        
        foreach($keys as $key)
        {
            if($key instanceof BaseKey)
            {
                $class->appendKey($key);
            }
            else
            {
                if($this->database->keys()->$key) $class->appendKey($this->database->keys()->$key);
            }
        }
    }

    public function revokeKey(string $tableName, BaseKey|string ...$keys) : void
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
     * @return CustomTable|QueryResult
     */
    public function getTable(string $name) : QueryResult|CustomTable
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

    private function returnClassInMap(string $className) : QueryResult|BaseTable
    {
        $table = $this->map[$className] ?? null;

        if(!$table) return $this->callException($className);

        return $table;
            
    }

    public function __get($name) : QueryResult|BaseTable
    {
        $table = $this->map[$name] ?? $this->map[NameSanitizer::sanitize($name)] ?? null;
        if(!$table) return $this->callException($name);

        return $table;
    }

    private function callException($tableName)  : QueryResult
    {
        return (new QueryManager($this->database))->makeQuery(new ExceptionsManager("Table '$tableName' not found",404,'Database'));
    }
}

?>