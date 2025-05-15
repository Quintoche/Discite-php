<?php
namespace DisciteDB\Core;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryBuilder;
use DisciteDB\QueryHandler\QueryHandler;
use DisciteDB\QueryHandler\QueryResult;
use DisciteDB\Tables\BaseTable;
use mysqli;

class QueryManager
{
    protected BaseTable $table;
    
    protected mysqli $connection;
    
    protected Operators $operator;

    protected QueryHandler $queryHandler;

    protected QueryBuilder $queryBuilder;

    protected QueryResult $queryResult;

    protected array $args;

    protected ?array $uuid = [];
    
    protected array $queryArray;
    
    protected string $queryString;

    public function __construct()
    {
        
    }

    public function setTable(BaseTable $table) : void
    {
        $this->table = $table;
    }

    public function setConnection(mysqli $connection) : void
    {
        $this->connection = $connection;
    }
    public function setOperator(Operators $operator) : void
    {
        $this->operator = $operator;
    }
    public function setArgs(?array $args) : void
    {
        $this->args = $args ?? [];
    }
    public function setUuid(?array $uuid = null) : void
    {
        $this->uuid = $uuid;
    }

    public function getTable() : ?BaseTable
    {
        return $this->table;
    }
    public function getOperator() : ?Operators
    {
        return $this->operator;
    }
    public function getConnection() : ?mysqli
    {
        return $this->connection;
    }
    public function getArgs() : ?array
    {
        return $this->args;
    }
    public function getUuid() : ?array
    {
        return $this->uuid;
    }

    public function getQueryHandler() : ?QueryHandler
    {
        return $this->queryHandler;
    }

    public function getQueryBuilder() : ?QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function getQueryResult() : ?QueryResult
    {
        return $this->queryResult;
    }
    
    public function makeQuery() : QueryResult
    {   
        $this->buildHandler();

        $this->buildQuery();

        $this->buildResult();

        return $this->queryResult;
    }    

    private function buildHandler() : void
    {
        $this->queryHandler =  new QueryHandler($this);
    }

    private function buildQuery() : void
    {
        $this->queryBuilder = new QueryBuilder($this);
    }

    private function buildResult() : void
    {
        $this->queryResult = new QueryResult($this);
    }
}

?>