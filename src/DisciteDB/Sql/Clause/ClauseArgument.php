<?php

namespace DisciteDB\Sql\Clause;

use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Methods\QueryMethodExpression;
use DisciteDB\Methods\QueryModifierExpression;

class ClauseArgument
{
    public static function evaluateArguments(mixed $args, QueryManager $queryManager, Database $database) : ?array
    {
        $_class = '\DisciteDB\Sql\Format\Format'.ucfirst($queryManager->getOperator()->name);
        
        return (new $_class($args, $database))->argumentsFormater($queryManager);
    }

    public static function isMethod(mixed $arg) : bool
    {
        return ($arg instanceof QueryMethodExpression);
    }
    public static function isModifier(mixed $arg) : bool
    {
        return ($arg instanceof QueryModifierExpression);
    }
    public static function isCondition(mixed $arg) : bool
    {
        return ($arg instanceof QueryConditionExpression);
    }



    public static function isLooseUsage(Database $database) : bool
    {
        return ($database->config()->getKeyUsage() === KeyUsage::LooseUsage);
    }

    public static function isValidArgument(string $key, mixed $value, Database $database, Operators $operator) : bool
    {
        return (self::isValidKey($key, $database) && self::isValidField(self::getValidKey($key,$database), $value, $operator));
    }

    private static function getValidKey(string $key, Database $database) : ?BaseKey
    {
        return $database->keys()->$key ?? null;
    }

    private static function isValidKey(string $key, Database $database) : bool
    {
        return !is_null($database->keys()->$key ?? null);
    }

    
    private static function isValidField(BaseKey $key, mixed $value, Operators $operator) : bool
    {
        if(!$key) return false;
        return $key->validateField($operator,$value);
    }

    public static function generateValidField(string $key, Database $database) : mixed
    {
        return self::getValidKey($key,$database)->generateField();
    }
}


?>