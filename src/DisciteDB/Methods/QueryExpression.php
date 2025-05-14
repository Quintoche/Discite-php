<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Methods\Handlers\HandlerBetween;
use DisciteDB\Methods\Handlers\HandlerContains;
use DisciteDB\Methods\Handlers\HandlerEqual;
use DisciteDB\Methods\Handlers\HandlerLessOrEqual;
use DisciteDB\Methods\Handlers\HandlerLessThan;
use DisciteDB\Methods\Handlers\HandlerLike;
use DisciteDB\Methods\Handlers\HandlerMoreOrEqual;
use DisciteDB\Methods\Handlers\HandlerMoreThan;
use DisciteDB\Methods\Handlers\HandlerNot;
use DisciteDB\Methods\Handlers\HandlerNotBetween;
use DisciteDB\Methods\Handlers\HandlerNotContains;
use DisciteDB\Methods\Handlers\HandlerNotIn;
use DisciteDB\Methods\Handlers\HandlerNotLike;
use DisciteDB\Methods\Handlers\HandlerOr;
use mysqli;

class QueryExpression
{
    protected QueryOperator $queryOperator;

    protected array $arguments;

    protected ?QueryLocation $queryLocation;

    protected mysqli $connection;

    public function __construct(QueryOperator $queryOperator, array $arguments)
    {
        $this->queryOperator = $queryOperator;

        
        
        match ($this->queryOperator) {
            QueryOperator::Contains, QueryOperator::NotContains,QueryOperator::NotLike,QueryOperator::Like => $this->containsOperatorArgs($arguments),
            default => $this->defaultOperatorArgs($arguments),
        };

    }
    
    public function returnSQL(string $key, mysqli $connection) : ?string
    {
        $this->connection = $connection;

        return match ($this->queryOperator)
        {
            QueryOperator::Or => (new HandlerOr($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::Contains => (new HandlerContains($key,$this->arguments,$this->queryLocation,$this->connection))->toSql(),
            QueryOperator::Like => (new HandlerLike($key,$this->arguments,$this->queryLocation,$this->connection))->toSql(),
            QueryOperator::NotLike => (new HandlerNotLike($key,$this->arguments,$this->queryLocation,$this->connection))->toSql(),
            QueryOperator::Between => (new HandlerBetween($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::Not => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toSql() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::NotIn => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toSql() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::NotContains => (new HandlerNotContains($key,$this->arguments,$this->queryLocation,$this->connection))->toSql(),
            QueryOperator::NotBetween => (new HandlerNotBetween($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::MoreThan => (new HandlerMoreThan($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::LessThan => (new HandlerLessThan($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::MoreOrEqual => (new HandlerMoreOrEqual($key,$this->arguments,$this->connection))->toSql(),
            QueryOperator::LessOrEqual => (new HandlerLessOrEqual($key,$this->arguments,$this->connection))->toSql(),
            default => (new HandlerEqual($key,$this->arguments,$this->connection))->toSql(),
        };
    }

    public function returnValues()
    {
        return $this->arguments['value'] ?? $this->arguments;
    }
    
    public function returnArgs() : array
    {
        return $this->arguments;
    }
    
    public function returnGlobal() : array
    {
        return (!$this->queryLocation) ? $this->arguments : ['value'=>$this->arguments,'location'=>$this->queryLocation];
    }

    public function returnOperator() : QueryOperator
    {
        return $this->queryOperator;
    }


    private function containsOperatorArgs(mixed $arguments) : void
    {
        $this->arguments[] = $arguments['value'];
        $this->queryLocation = $arguments['location'];
    }

    private function defaultOperatorArgs(mixed $arguments) : void
    {
        $this->arguments = $arguments;
    }

}
?>