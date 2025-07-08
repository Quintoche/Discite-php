<?php

namespace DisciteDB\Sql\Format;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Sql\Clause\ClauseArgument;

class FormatRetrieve
{
    protected Operators $operator = Operators::Retrieve;

    protected Database $database;

    protected ?array $args;

    public function __construct(?array $args, Database $database)
    {
        $this->args = $args ?? [];

        $this->database = $database;
    }

    public function argumentsFormater(QueryManager $query) : ?array
    {
        if($this->argsLooseUsage()) return $this->args;

        return $this->argsLoop($query);
    }






    private function argsLoop(QueryManager $query) : ?array
    {
        $_array = [];
        $columns = [];

        foreach($query->getTable()->getMap() as $key)
        {
            $columns[] = $key->getAlias();
        }

        foreach($this->args as $k => $v)
        {
            if(!in_array($k,$columns) && !is_int($k)) continue;

            if($this->argsInstanceCheck($v)) 
            {
                $_array[$k] = $v;
                continue;
            }
            
            if(!$this->argsValidArgumentCheck($query->getTable()->getName().'_'.$k, $v))
            {
                $this->arrayUnset($k); 
                continue;
            }

            $_array[$k] = $this->argsValidArgumentGenerator($query->getTable()->getName().'_'.$k);
        }

        return $_array;
    }
    private function argsLooseUsage() : bool
    {
        return (ClauseArgument::isLooseUsage($this->database));
    }

    private function argsInstanceCheck(mixed $value) : bool
    {
        return ($this->argsMethodCheck($value) || $this->argsConditionCheck($value) || $this->argsModifierCheck($value));
    }

    private function argsMethodCheck(mixed $value) : bool
    {
        return (ClauseArgument::isMethod($value));
    }
    private function argsConditionCheck(mixed $value) : bool
    {
        return (ClauseArgument::isCondition($value));
    }
    private function argsModifierCheck(mixed $value) : bool
    {
        return (ClauseArgument::isModifier($value));
    }
    private function argsValidArgumentCheck(string $key, mixed $value)
    {
        return ClauseArgument::isValidArgument($key, $value, $this->database, $this->operator);
    }
    private function argsValidArgumentGenerator(string $key) : mixed
    {
        return ClauseArgument::generateValidField($key, $this->database);
    }

    private function arrayUnset($key) : void
    {
        unset($this->args[$key]);
    }

}

?>