<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Sql\Data\DataKey;

class HandlerUuid
{
    protected ?array $argumentArray;

    protected ?array $argumentKeys;

    protected ?array $argumentValues;

    protected ?array $argumentArguments;

    protected QueryManager $queryManager;
    
    protected ?array $args;

    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->args = $this->queryManager->getUuid();

        $this->createArgs();
    }

    public function retrieve() : array
    {
        return $this->argumentArray;
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
            'UUID_KEY' => $this->argumentKeys,
            'UUID_VALUE' => $this->argumentValues,
            'UUID' => $this->argumentArguments,
        ];
    }
    private function createArgsKeys(string $key) : string
    {
        return DataKey::escape($key, $this->queryManager->getConnection());
    }
    private function createArgsValues(mixed $value) : QueryConditionExpression
    {
        return ($value instanceof QueryConditionExpression) ? $value : new QueryConditionExpression(QueryOperator::Equal,[$value]);
    }
    private function createArgsArguments(string $key, mixed $value) : string
    {
        return ($value instanceof QueryConditionExpression) ? $value->returnCondition($key, $this->queryManager->getConnection()) : (new QueryConditionExpression(QueryOperator::Equal,[$value]))->returnCondition($key, $this->queryManager->getConnection());
    }
}

?>