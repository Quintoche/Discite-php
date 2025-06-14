<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Methods\QueryModifierExpression;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataTable;

class HandlerArgument
{
    protected ?array $argumentArray;

    protected ?array $argumentKeys;

    protected ?array $argumentValues;

    protected ?array $argumentArguments;

    protected ?array $definedColumn = null;

    protected QueryManager $queryManager;

    protected Operators $operator;
    
    protected ?array $args;

    public function __construct(QueryManager $queryManager, ?array $column = null)
    {
        $this->queryManager = $queryManager;
        $this->definedColumn = $column;

        $this->args = $this->escapeArgs($this->queryManager->getArgs());

        $this->createArgs();
    }

    public function retrieve() : array
    {
        return $this->argumentArray;
    }

    public function add($k, $v, $a)
    {

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
            if(is_int($k) && is_array($v))
            {
                $k = array_keys($v)[0];
                $v = array_values($v)[0];
            }

            $_array_keys[] = $this->createArgsKeys($k);
            $_array_values[] = $this->createArgsValues($v);
            $_array_arguments[] = $this->createArgsArguments($k, $v);
        }

        if($this->definedColumn && $this->queryManager->getOperator() == Operators::Search)
        {
            $_value = array_values($this->queryManager->getArgs())[0];
            $_column = $this->definedColumn[$this->queryManager->getTable()->getAlias()] ?? $this->definedColumn[$this->queryManager->getTable()->getName()];

            foreach($_column as $columnData)
            {
                if(!is_array($columnData)) continue;

                foreach($columnData as $name => $data)
                {
                    foreach($data as $k => $v)
                    {
                        $_array_keys[] = DataTable::escape($name).'.'. $this->createArgsKeys($v);
                        $_array_values[] = $this->createArgsValues($_value);
                        $_array_arguments[] = str_replace('{TABLE}',DataTable::escape($name),$this->createArgsArguments($v, $_value));
                    }
                }
            }
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
            Operators::Search => ' OR ',
            default => ' AND ',
        };
    }
    private function createArgsKeys(string $key) : string
    {
        return DataKey::escape($key, $this->queryManager->getConnection());
    }
    private function createArgsValues(mixed $value) : string
    {
        if(is_array($value)) $value = array_values($value)[0];
        return ($value instanceof QueryConditionExpression) ? $value->returnValue($this->queryManager->getConnection()) : (new QueryConditionExpression(QueryOperator::Equal,[$value]))->returnValue($this->queryManager->getConnection());
    }
    private function createArgsArguments(string $key, mixed $value) : string
    {
        if(is_array($value)) $value = array_values($value)[0];
        return ($value instanceof QueryConditionExpression) ? $value->returnCondition($key, $this->queryManager->getConnection()) : (new QueryConditionExpression(QueryOperator::Equal,[$value]))->returnCondition($key, $this->queryManager->getConnection());
    }
}

?>