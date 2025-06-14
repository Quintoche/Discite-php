<?php

namespace DisciteDB\Sql\Format;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Methods\QueryCondition;
use DisciteDB\Sql\Clause\ClauseArgument;
use DisciteDB\Tables\BaseTable;

class FormatSearch
{
    protected Operators $operator = Operators::Listing;

    protected Database $database;

    protected mixed $args;

    protected array $bannedKeys = [
        'image'
    ];

    public function __construct(mixed $args, Database $database)
    {
        $this->args = $args ?? [];

        $this->database = $database;
    }

    public function argumentsFormater(QueryManager $queryManager) : ?array
    {
        if($this->argsLooseUsage()) return (array) $this->args;

        $args = $this->argsLoop($queryManager->getTable());
        $queryManager->getPonderationUtily()->setArgument($args);

        return $args;
    }

    private function argsLoop(BaseTable $table) : ?array
    {
        return match(true)
        {
            is_array($this->args) => $this->formatArrayFromArray($table,$this->args),
            is_null($this->args) => [],
            default => $this->formatArrayFromString($table,$this->args),
        };
    }

    private function formatArrayFromArray(BaseTable $table, array $args) : array
    {
        $_array = [];

        foreach($table->getMap() as $key)
        {
            if(in_array($key->getAlias(),$this->bannedKeys)) continue;

            foreach($args as $argv)
            {
                foreach($this->createSingleWildcard($argv) as $arg)
                {
                    $_array[] = [$key->getAlias() ?? $key->getName() => QueryCondition::Contains($arg)];
                }
            }
        }

        return $_array;
    }

    private function formatArrayFromString(BaseTable $table, mixed $args) : array
    {
        $_array = [];
        
        foreach($table->getMap() as $key)
        {
            if(in_array($key->getAlias(),$this->bannedKeys)) continue;

            foreach($this->createSingleWildcard($args) as $arg)
            {
                $_array[] = [$key->getAlias() ?? $key->getName() => QueryCondition::Contains($arg)];
            }
        }

        return $_array;
    }

    private function createSingleWildcard(string $arg) : array
    {
        $argLetters = str_split($arg);
        $argLength = sizeof($argLetters);

        if($argLength < 2) return [$arg];

        $_array = [];

        for($i=0;$i<$argLength;$i++)
        {
            $newArgLetters = $argLetters;
            $newArgLetters[$i] = '_';

            $_array[] = implode('',$newArgLetters);
        }

        return $_array;
    }

    private function argsLooseUsage() : bool
    {
        return (ClauseArgument::isLooseUsage($this->database));
    }
}

?>