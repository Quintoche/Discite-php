<?php

namespace DisciteDB\Sql\Clause;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryCondition;
use DisciteDB\Database;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Methods\QueryMethodExpression;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Users\BaseUser;
use mysqli;

class ClauseMethod
{
    protected ?array $arguments;

    protected ?array $uuid;

    protected Database $database;

    protected mysqli $connection;

    protected Operators $operator;

    protected BaseTable $table;

    protected BaseUser $user;

    public function __construct(BaseTable $table, Operators $operator, mysqli $connection, Database $database, ?array $arguments)
    {
        $this->table = $table;
        $this->database = $database;
        $this->operator = $operator;
        $this->connection = $connection;
        
        $this->arguments = $this->escapeArguments($arguments);
    }

    public function makeQuery() : array
    {
        return $this->arguments;
    }


    private function escapeArguments(?array $args) : ?array
    {
        $_array = [];

        foreach($args as $k => $v)
        {

            if(ClauseArgument::isMethod($v)) continue;

            if(ClauseArgument::isModifier($v)) 
            {
                $_array[] = $this->setArgModifier($v);
            }
            elseif(ClauseArgument::isCondition($v))
            {
                $_array[] = $this->setArgCondition($k,$v);
            }
            else
            {
                $_array[] = $this->setArgEqual($k,$v);
            }
        }
        
        return $_array;
    }
    private function setArgModifier(mixed $value) : array
    {
        $_value = $value->toDatas($this->connection);

        return [
            'type' => $_value['modifier']->name,
            'value' => $_value['value'],
        ];
    }
    private function setArgCondition(string $key, QueryConditionExpression $value) : array
    {

        $_value = $value->toDatas($key, $this->connection);

        return [
            'type' => $_value['modifier']->name,
            'key' => $_value['key'],
            'value' => $_value['value'],
        ];
    }
    private function setArgEqual(string $key, mixed $value) : array
    {
        return [
            'type' => QueryCondition::Equal->name,
            'key' => $key,
            'value' => $value,
        ];
    }

    public static function hasQueryMethod(?array $args) : bool
    {
        return (bool) array_filter((array) $args, fn($v) => $v instanceof QueryMethodExpression);
    }

}

?>