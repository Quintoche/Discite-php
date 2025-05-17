<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Methods\QueryClause;
use DisciteDB\Methods\QueryExpression;
use DisciteDB\Sql\Data\DataKey;
use mysqli;

class HandlerArgument
{
    protected ?array $argumentArray;

    protected ?array $argumentKeys;

    protected ?array $argumentValues;

    protected ?array $argumentArguments;

    protected mysqli $connection;

    protected Operators $operator;
    
    protected ?array $args;

    public function __construct(array $args, Operators $operator ,mysqli $connection)
    {
        $this->args = $this->escapeArgs($args);
        $this->connection = $connection;
        $this->operator = $operator;

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
            if($v instanceof QueryClause) continue;
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
        return match ($this->operator) {
            Operators::Update => ', ',
            default => ' AND ',
        };
    }
    private function createArgsKeys(string $key) : string
    {
        return DataKey::escape($key, $this->connection);
    }
    private function createArgsValues(mixed $value) : string
    {
        return ($value instanceof QueryExpression) ? $value->returnValue($this->connection) : (new QueryExpression(QueryOperator::Equal,[$value]))->returnValue($this->connection);
    }
    private function createArgsArguments(string $key, mixed $value) : string
    {
        return ($value instanceof QueryExpression) ? $value->returnCondition($key, $this->connection) : (new QueryExpression(QueryOperator::Equal,[$value]))->returnCondition($key, $this->connection);
    }
}

?>