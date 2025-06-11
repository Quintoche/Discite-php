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

        $queryManager->getPonderationUtily()->setArgument($this->args);

        return $this->argsLoop($queryManager->getTable());
    }

    private function argsLoop(BaseTable $table) : ?array
    {
        $_array = [];

        return match(true)
        {
            is_array($this->args) => [''],
            is_null($this->args) => [],
            default => $this->createArray($table,$this->args),
        };
    }

    private function createArray(BaseTable $table, $arg)
    {
        $_array = [];

        foreach($table->getMap() as $key)
        {
            if(in_array($key->getAlias(),$this->bannedKeys)) continue;

            $_array[$key->getAlias() ?? $key->getName()] = QueryCondition::Contains($arg);
        }

        return $_array;
    }


    private function argsLooseUsage() : bool
    {
        return (ClauseArgument::isLooseUsage($this->database));
    }
}

?>