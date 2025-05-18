<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Methods\QueryModifierExpression;
use mysqli;

class HandlerModifier
{
    protected ?array $argumentArray;

    protected ?array $argumentArguments;

    protected mysqli $connection;
    
    protected ?array $args;

    public function __construct(array $args, mysqli $connection)
    {
        $this->args = $this->escapeArgs($args);
        $this->connection = $connection;

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
            if(!$v instanceof QueryModifierExpression) continue;
            $_array[] = $v;
        }

        return $_array;
    }

    private function createArgs()
    {
        $_array_arguments = [];

        foreach($this->args as $v)
        {
            $_array_arguments[] = $this->createArgsArguments($v);
        }

        $this->argumentArguments = $_array_arguments;

        $this->argumentArray = [
            'MODIFIER' => $this->argumentArguments,
            'SEPARATOR' => $this->createArgsSeparator()
        ];
    }
    private function createArgsSeparator()
    {
        return ' ';
    }

    private function createArgsArguments(mixed $value) : ?string
    {
        return ($value instanceof QueryModifierExpression) ? $value->returnCondition($this->connection) : null;
    }
}

?>