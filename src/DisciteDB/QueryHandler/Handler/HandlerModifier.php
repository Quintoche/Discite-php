<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryModifierExpression;

class HandlerModifier
{
    protected ?array $argumentArray;

    protected ?array $argumentArguments;

    protected QueryManager $queryManager;
    
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
        return ($value instanceof QueryModifierExpression) ? $value->returnSql($this->queryManager->getConnection()) : null;
    }
}

?>