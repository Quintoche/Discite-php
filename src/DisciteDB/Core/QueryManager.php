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

    protected QueryHandler $query;

    protected QueryBuilder $build;

    protected QueryResult $result;

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
    public function setArgs(array $args) : void
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
    
    public function makeQuery() : array
    {   
        $this->query = $this->buildHandler();

        $this->build = $this->buildQuery();

        $this->result = $this->buildResult($this->build, $this->getConnection(), $this->getOperator());

        return $this->result->createResult();
    }    

    private function buildHandler() : QueryHandler
    {
        return new QueryHandler($this);
    }

    private function buildQuery() : QueryBuilder
    {
        return new QueryBuilder($this->query);
    }

    private function buildResult(QueryBuilder $query, mysqli $connection, Operators $operator)
    {
        return new QueryResult($query, $connection, $operator);
    }


    // QueryBuilder => Create Patern ;
    // QueryStructure => Regroup QueryArguments // QueryJoin
    // QueryArguments => create array with every arguments based on patern ;
    // QueryJoin => Check for foreign key ;
    // 
}

?>