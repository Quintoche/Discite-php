<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Config\Default\QueryTemplateConfig;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryTemplate;
use DisciteDB\Sql\Data\DataDatabase;
use DisciteDB\Sql\Data\DataTable;
use DisciteDB\Tables\BaseTable;

class HandlerStructure
{
    protected ?array $structureArray;

    protected ?string $structureColumn = null;

    protected ?string $structureColumns = null;

    protected ?string $structureDatabase = null;

    protected ?string $structureTable = null;

    protected Operators $operator;

    protected BaseTable $table;


    public function __construct(BaseTable $table, Operators $operator)
    {
        $this->table = $table;
        $this->operator = $operator;

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
        return '*';
    }
    private function getStructureColumns() : string
    {
        return match ($this->operator) {
            Operators::Count, Operators::CountAll => 'COUNT(*)',
            Operators::Sum => 'SUM({COLUMN})',
            Operators::Average => 'AVG({COLUMN})',
            default => '*',
        };
    }
    private function getStructureDatabase() : string
    {
        return DataDatabase::escape(ConnectionConfig::$DATABASE) ?? DataDatabase::escape(ConnectionConfig::DEFAULT_DATABASE);
    }
    private function getStructureTable() : string
    {
        return DataTable::escape($this->table->getName()) ?? DataTable::escape($this->table->getAlias());
    }
}

?>