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
    
    public function returnCondition(string $key, mysqli $connection) : ?string
    {
        $this->connection = $connection;

        return match ($this->queryOperator)
        {
            QueryOperator::Or => (new HandlerOr($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::Contains => (new HandlerContains($key,$this->arguments,$this->queryLocation,$this->connection))->toCondition(),
            QueryOperator::Like => (new HandlerLike($key,$this->arguments,$this->queryLocation,$this->connection))->toCondition(),
            QueryOperator::NotLike => (new HandlerNotLike($key,$this->arguments,$this->queryLocation,$this->connection))->toCondition(),
            QueryOperator::Between => (new HandlerBetween($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::Not => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toCondition() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::NotIn => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toCondition() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::NotContains => (new HandlerNotContains($key,$this->arguments,$this->queryLocation,$this->connection))->toCondition(),
            QueryOperator::NotBetween => (new HandlerNotBetween($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::MoreThan => (new HandlerMoreThan($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::LessThan => (new HandlerLessThan($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::MoreOrEqual => (new HandlerMoreOrEqual($key,$this->arguments,$this->connection))->toCondition(),
            QueryOperator::LessOrEqual => (new HandlerLessOrEqual($key,$this->arguments,$this->connection))->toCondition(),
            default => (new HandlerEqual($key,$this->arguments,$this->connection))->toCondition(),
        };
    }
    
    public function returnValue(mysqli $connection) : ?string
    {
        $this->connection = $connection;

        $key = '';

        return match ($this->queryOperator)
        {
            QueryOperator::Or => (new HandlerOr($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::Contains => (new HandlerContains($key,$this->arguments,$this->queryLocation,$this->connection))->toValue(),
            QueryOperator::Like => (new HandlerLike($key,$this->arguments,$this->queryLocation,$this->connection))->toValue(),
            QueryOperator::NotLike => (new HandlerNotLike($key,$this->arguments,$this->queryLocation,$this->connection))->toValue(),
            QueryOperator::Between => (new HandlerBetween($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::Not => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toValue() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::NotIn => (sizeof($this->arguments) == 1) ? (new HandlerNot($key,$this->arguments,$this->connection))->toValue() : (new HandlerNotIn($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::NotContains => (new HandlerNotContains($key,$this->arguments,$this->queryLocation,$this->connection))->toValue(),
            QueryOperator::NotBetween => (new HandlerNotBetween($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::MoreThan => (new HandlerMoreThan($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::LessThan => (new HandlerLessThan($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::MoreOrEqual => (new HandlerMoreOrEqual($key,$this->arguments,$this->connection))->toValue(),
            QueryOperator::LessOrEqual => (new HandlerLessOrEqual($key,$this->arguments,$this->connection))->toValue(),
            default => (new HandlerEqual($key,$this->arguments,$this->connection))->toValue(),
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