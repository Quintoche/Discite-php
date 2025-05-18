<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Methods\ConditionHandlers\HandlerBetween;
use DisciteDB\Methods\ConditionHandlers\HandlerContains;
use DisciteDB\Methods\ConditionHandlers\HandlerEqual;
use DisciteDB\Methods\ConditionHandlers\HandlerLessOrEqual;
use DisciteDB\Methods\ConditionHandlers\HandlerLessThan;
use DisciteDB\Methods\ConditionHandlers\HandlerLike;
use DisciteDB\Methods\ConditionHandlers\HandlerMoreOrEqual;
use DisciteDB\Methods\ConditionHandlers\HandlerMoreThan;
use DisciteDB\Methods\ConditionHandlers\HandlerNot;
use DisciteDB\Methods\ConditionHandlers\HandlerNotBetween;
use DisciteDB\Methods\ConditionHandlers\HandlerNotContains;
use DisciteDB\Methods\ConditionHandlers\HandlerNotIn;
use DisciteDB\Methods\ConditionHandlers\HandlerNotLike;
use DisciteDB\Methods\ConditionHandlers\HandlerOr;
use mysqli;

class QueryConditionExpression
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