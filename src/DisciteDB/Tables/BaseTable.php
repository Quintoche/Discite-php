<?php

namespace DisciteDB\Tables;

use DisciteDB\Connection;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Keys\KeyTemplates\TemplateId;

abstract class BaseTable
{
    use TableTraitGet, TableTraitSet, TableTraitMap;

    protected Database $database;

    protected Connection $connection;

    protected QueryManager $query;

    protected ?string $name = null;
    
    protected ?string $alias = null;
    
    protected ?string $prefix = null;

    protected ?BaseKey $indexKey = null;

    protected ?string $sort = 'DESC';

    protected array $map;

    public function __construct(Database $database)
    {
        $this->database = $database;

        $this->connection = $this->database->connection();

        $this->indexKey = new TemplateId($this->database);

        $this->query = new QueryManager();
        $this->query->setTable($this);
        $this->query->setConnection($this->database->connection()->get());
    } 

    private function setQuery()
    {
        
    }
}

?>