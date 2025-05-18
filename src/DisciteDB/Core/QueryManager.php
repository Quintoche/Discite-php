<?php
namespace DisciteDB\Core;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryType;
use DisciteDB\Database;
use DisciteDB\QueryHandler\QueryBuilder;
use DisciteDB\QueryHandler\QueryHandler;
use DisciteDB\QueryHandler\QueryResult;
use DisciteDB\Tables\BaseTable;
use mysqli;

class QueryManager
{
    protected Database $database;

    protected ?ExceptionsManager $exception = null;
    
    protected ?BaseTable $table = null;
    
    protected ?mysqli $connection = null;
    
    protected ?Operators $operator = null;

    protected ?QueryHandler $queryHandler = null;

    protected ?QueryBuilder $queryBuilder = null;

    protected QueryResult $queryResult;

    protected QueryType $queryType = QueryType::Data;

    protected ?array $args = null;

    protected ?array $uuid = [];
    
    protected ?array $queryArray = null;
    
    protected ?string $queryString = null;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getInstance() : Database
    {
        return $this->database;
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
    public function setType(QueryType $type) : void
    {
        $this->queryType = $type;
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
    public function getType() : QueryType
    {
        return $this->queryType;
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
    
    public function makeQuery(?ExceptionsManager $exception = null) : QueryResult
    {   
        $this->setException($exception);

        $this->buildHandler();

        $this->buildQuery();

        $this->buildResult();

        return $this->queryResult;
    }    

    private function buildHandler() : void
    {
        if($this->exception) return;
        $this->queryHandler =  new QueryHandler($this);
    }

    private function buildQuery() : void
    {
        if($this->exception) return;
        $this->queryBuilder = new QueryBuilder($this);
    }

    private function buildResult() : void
    {
        $this->queryResult = new QueryResult($this, $this->queryType);
    }

    private function setException(?ExceptionsManager $exception = null) : void
    {
        if(!$exception) return;
        $this->exception = $exception;
        $this->queryType = QueryType::Exception;
    }
    public function getException() : ExceptionsManager
    {
        return $this->exception;
    }
}

?>