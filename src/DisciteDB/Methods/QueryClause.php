<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Methods\Clauses\ClauseLimit;
use DisciteDB\Methods\Clauses\ClauseSort;
use mysqli;

class QueryClause
{
    protected QueryOperator $queryOperator;

    protected array $arguments;

    protected ?QuerySort $queryMethod;

    protected mysqli $connection;

    public function __construct(QueryOperator $queryOperator, array $arguments)
    {
        $this->queryOperator = $queryOperator;
        
        $this->defaultOperatorArgs($arguments);
    }

    public function returnCondition(mysqli $connection) : ?string
    {
        $this->connection = $connection;

        return match ($this->queryOperator)
        {
            QueryOperator::Sort => (new ClauseSort($this->arguments,$this->connection))->toCondition(),
            QueryOperator::Limit => (new ClauseLimit($this->arguments,$this->connection))->toCondition(),
            default => null,
        };
    }

    private function defaultOperatorArgs(array $args) : void
    {
        $this->arguments = $args;
    }
}

?>