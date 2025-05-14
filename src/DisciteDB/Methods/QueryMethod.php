<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Config\Enums\QueryOperator;

class QueryMethod
{

    public static function Equal(mixed $arg) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Equal, [$arg]);
    }
    public static function Or(mixed ...$args) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Or, $args);
    }
    public static function Contains(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Contains, ['value'=>$value,'location'=>$location]);
    }
    public static function Between(int $start, int $end) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Between,[$start, $end]);
    }
    public static function Not(mixed ...$args) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Not, $args);
    }
    public static function NotIn(mixed ...$args) : QueryExpression
    {
        return new QueryExpression(QueryOperator::NotIn, $args);
    }
    public static function NotContains(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryExpression
    {
        return new QueryExpression(QueryOperator::NotContains, ['value'=>$value,'location'=>$location]);
    }
    public static function Like(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryExpression
    {
        return new QueryExpression(QueryOperator::Like, ['value'=>$value,'location'=>$location]);
    }
    public static function NotLike(mixed $value, QueryLocation $location = QueryLocation::Between) : QueryExpression
    {
        return new QueryExpression(QueryOperator::NotLike, ['value'=>$value,'location'=>$location]);
    }
    public static function NotBetween(mixed ...$args) : QueryExpression
    {
        return new QueryExpression(QueryOperator::NotBetween, $args);
    }
    public static function MoreThan(int $arg) : QueryExpression
    {
        return new QueryExpression(QueryOperator::MoreThan, [$arg]);
    }
    public static function LessThan(int $arg) : QueryExpression
    {
        return new QueryExpression(QueryOperator::LessThan, [$arg]);
    }
    public static function MoreOrEqual(int $arg) : QueryExpression
    {
        return new QueryExpression(QueryOperator::MoreOrEqual, [$arg]);
    }
    public static function LessOrEqual(int $arg) : QueryExpression
    {
        return new QueryExpression(QueryOperator::LessOrEqual, [$arg]);
    }
    


}
?>