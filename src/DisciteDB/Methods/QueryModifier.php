<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;

class QueryModifier
{
    public static function Order(QuerySort $sortMethod ,BaseKey|string $key) : QueryModifierExpression
    {
        return new QueryModifierExpression(QueryOperator::Sort, [$sortMethod, $key]);
    }

    public static function Sort(QuerySort $sortMethod ,BaseKey|string $key) : QueryModifierExpression
    {
        return new QueryModifierExpression(QueryOperator::Sort, [$sortMethod, $key]);
    }

    public static function Limit(int $limit = 0, ?int $offset = 0) : QueryModifierExpression
    {
        return new QueryModifierExpression(QueryOperator::Limit, [$limit, $offset]);
    }
}
?>