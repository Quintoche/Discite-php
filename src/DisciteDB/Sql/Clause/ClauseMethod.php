<?php

namespace DisciteDB\Sql\Clause;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Connection;
use DisciteDB\Database;
use DisciteDB\Methods\QueryMethodExpression;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Users\BaseUser;

class ClauseMethod
{
    protected ?array $arguments;

    protected Database $database;

    protected Connection $connection;

    protected Operators $operator;

    protected BaseTable $table;

    protected BaseUser $user;

    public function __construct()
    {
        
    }

    public function makeQuery()
    {
        
    }


    private function validateArguments()
    {

    }
    private function setArguments()
    {

    }
    private function remArguments()
    {

    }

    public static function hasQueryMethod(?array $args) : bool
    {
        return (bool) array_filter((array) $args, fn($v) => $v instanceof QueryMethodExpression);
    }

}

?>