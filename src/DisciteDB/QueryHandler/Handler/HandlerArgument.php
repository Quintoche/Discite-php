<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Methods\QueryModifierExpression;
use DisciteDB\Sql\Data\DataKey;

class HandlerArgument
{
    protected ?array $argumentArray;

    protected ?array $argumentKeys;

    protected ?array $argumentValues;

    protected ?array $argumentArguments;

    protected QueryManager $queryManager;

    protected Operators $operator;
    
    protected ?array $args;

    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->args = $this->escapeArgs($this->queryManager->getArgs());

        $this->createArgs();
    }

    public function retrieve() : array
    {
        return $this->argumentArray;
    }

    private function escapeArgs(mixed $args) : ?array
    {
        $_array = [];

        foreach($args as $k => $v)
        {
            if($v instanceof QueryModifierExpression) continue;
            $_array[$k] = $v;
        }

        return $_array;
    }

    private function createArgs()
    {
        $_array_keys = [];
        $_array_values = [];
        $_array_arguments = [];

        foreach($this->args as $k => $v)
        {
            $_array_keys[] = $this->createArgsKeys($k);
            $_array_values[] = $this->createArgsValues($v);
            $_array_arguments[] = $this->createArgsArguments($k, $v);
        }

        $this->argumentKeys = $_array_keys;
        $this->argumentValues = $_array_values;
        $this->argumentArguments = $_array_arguments;

        $this->argumentArray = [
            'KEYS' => $this->argumentKeys,
            'VALUES' => $this->argumentValues,
            'CONDITIONS' => $this->argumentArguments,
            'SEPARATOR' => $this->createArgsSeparator()
        ];
    }
    private function createArgsSeparator()
    {
        return match ($this->queryManager->getOperator()) {
            Operators::Update => ', ',
            default => ' AND ',
        };
    }
    private function createArgsKeys(string $key) : string
    {
        return DataKey::escape($key, $this->queryManager->getConnection());
    }
    private function createArgsValues(mixed $value) : string
    {
        return ($value instanceof QueryConditionExpression) ? $value->returnValue($this->queryManager->getConnection()) : (new QueryConditionExpression(QueryOperator::Equal,[$value]))->returnValue($this->queryManager->getConnection());
    }
    private function createArgsArguments(string $key, mixed $value) : string
    {
        return ($value instanceof QueryConditionExpression) ? $value->returnCondition($key, $this->queryManager->getConnection()) : (new QueryConditionExpression(QueryOperator::Equal,[$value]))->returnCondition($key, $this->queryManager->getConnection());
    }
}

?>