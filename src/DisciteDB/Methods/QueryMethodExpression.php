<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Methods\MethodHandlers\HandlerAsync;
use mysqli;

class QueryMethodExpression
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
            QueryOperator::Async => (new HandlerAsync($this->arguments,$this->connection))->toCondition(),
            default => null,
        };
    }

    private function defaultOperatorArgs(array $args) : void
    {
        $this->arguments = $args;
    }
}

?>