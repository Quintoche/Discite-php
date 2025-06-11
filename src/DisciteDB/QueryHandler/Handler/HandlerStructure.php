<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Sql\Data\DataDatabase;
use DisciteDB\Sql\Data\DataTable;

class HandlerStructure
{
    protected ?array $structureArray;

    protected ?string $structureColumn = null;

    protected ?string $structureColumns = null;

    protected ?string $structureDatabase = null;

    protected ?string $structureTable = null;

    protected ?array $definedColumn = null;

    protected QueryManager $queryManager;


    public function __construct(QueryManager $queryManager, ?array $column = null)
    {
        $this->queryManager = $queryManager;
        $this->definedColumn = $column;

        $this->createStructure();
        $this->createArray();
    }

    public function retrieve() : array
    {
        return $this->structureArray;
    }

    private function selectStructure() : array
    {
        return ['column','columns','database','table'];
    }    
    private function createStructure() : void
    {
        foreach($this->selectStructure() as $data)
        {
            $this->{'structure'.ucfirst($data)} = $this->{'getStructure'.ucfirst($data)}();
        }
    }
    private function createArray() : void
    {
        $this->structureArray['COLUMN'] = $this->structureColumn;
        $this->structureArray['COLUMNS'] = $this->structureColumns;
        $this->structureArray['DATABASE'] = $this->structureDatabase;
        $this->structureArray['TABLE'] = $this->structureTable;
    }

    private function getStructureColumn() : string
    {
        return implode(', ',$this->buildSqlColumns($this->definedColumn,'',0));
    }

    function buildSqlColumns(array $structure, string $prefix = '', int $depth = 0): array 
    {
        $columns = [];
    
        foreach ($structure as $table => $fields) 
        {
            $simpleColumns = [];
            $nestedTables = [];
    
            foreach ($fields as $field) 
            {
                if (is_array($field)) 
                {
                    $nestedTables[] = $field;
                } else 
                {
                    $simpleColumns[] = $field;
                }
            }
    
            if ($depth === 0) 
            {
                foreach ($simpleColumns as $col) {
                    $columns[] = "`$table`.`$col` AS '$col'";
                }
            }
    
            if ($depth >= 1) 
            {
                $jsonParts = [];
                foreach ($simpleColumns as $col) 
                {
                    $jsonParts[] = "'$col', `$table`.`$col`";
                }
    
                foreach ($nestedTables as $subTable) 
                {
                    $sub = $this->buildSqlColumns($subTable, $prefix, $depth + 1);
                    foreach ($sub as $item) 
                    {
                        $jsonParts[] = "'".explode(' AS ', $item)[1]."', ".explode(' AS ', $item)[0];
                    }
                }
    
                $columns[] = "JSON_OBJECT(" . implode(', ', $jsonParts) . ") AS {$table}";
            }
    
            foreach ($nestedTables as $subTable) 
            {
                $columns = array_merge($columns, $this->buildSqlColumns($subTable, $prefix, $depth + 1));
            }
        }

        if(empty($columns)) $columns[] = '*';
    
        return $columns;
    }
    

    private function getStructureColumns() : string
    {
        return match ($this->queryManager->getOperator()) {
            Operators::Count, Operators::CountAll => 'COUNT(*)',
            Operators::Sum => 'SUM({COLUMN})',
            Operators::Average => 'AVG({COLUMN})',
            // Operators::Search => $this->structureColumn.', '.$this->createPonderate(),
            default => $this->structureColumn,
        };
    }
    private function getStructureDatabase() : string
    {
        return DataDatabase::escape(ConnectionConfig::$DATABASE) ?? DataDatabase::escape(ConnectionConfig::DEFAULT_DATABASE);
    }
    private function getStructureTable() : string
    {
        return DataTable::escape($this->queryManager->getTable()->getName()) ?? DataTable::escape($this->queryManager->getTable()->getAlias());
    }

    private function createPonderate() : string
    {
        return $this->queryManager->getPonderationUtily()->setTable($this->queryManager->getTable())->handle();
    }
}

?>