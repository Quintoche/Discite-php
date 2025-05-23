<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Methods\ModifierHandlers\HandlerLimit;
use DisciteDB\Methods\ModifierHandlers\HandlerSort;
use mysqli;

class QueryModifierExpression
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

    public function returnSql(mysqli $connection) : ?string
    {
        $this->connection = $connection;

        return match ($this->queryOperator)
        {
            QueryOperator::Sort => (new HandlerSort($this->arguments,$this->connection))->toSql(),
            QueryOperator::Limit => (new HandlerLimit($this->arguments,$this->connection))->toSql(),
            default => null,
        };
    }

    private function defaultOperatorArgs(array $args) : void
    {
        $this->arguments = $args;
    }
}

?>