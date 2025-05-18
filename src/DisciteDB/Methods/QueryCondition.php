<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Config\Enums\QueryOperator;

class QueryCondition
{

    public static function Equal(mixed $arg) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Equal, [$arg]);
    }
    public static function Or(mixed ...$args) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Or, $args);
    }
    public static function Contains(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Contains, ['value'=>$value,'location'=>$location]);
    }
    public static function Between(int $start, int $end) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Between,[$start, $end]);
    }
    public static function Not(mixed ...$args) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Not, $args);
    }
    public static function NotIn(mixed ...$args) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::NotIn, $args);
    }
    public static function NotContains(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::NotContains, ['value'=>$value,'location'=>$location]);
    }
    public static function Like(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::Like, ['value'=>$value,'location'=>$location]);
    }
    public static function NotLike(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::NotLike, ['value'=>$value,'location'=>$location]);
    }
    public static function NotBetween(mixed ...$args) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::NotBetween, $args);
    }
    public static function MoreThan(int $arg) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::MoreThan, [$arg]);
    }
    public static function LessThan(int $arg) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::LessThan, [$arg]);
    }
    public static function MoreOrEqual(int $arg) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::MoreOrEqual, [$arg]);
    }
    public static function LessOrEqual(int $arg) : QueryConditionExpression
    {
        return new QueryConditionExpression(QueryOperator::LessOrEqual, [$arg]);
    }
    


}
?>