<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;


class QueryModifier
{


    public static function order(QuerySort $sortMethod ,BaseKey|string $key) : QueryClause
    {
        return new QueryClause(QueryOperator::Sort, [$sortMethod, $key]);
    }

    public static function sort(QuerySort $sortMethod ,BaseKey|string $key) : QueryClause
    {
        return new QueryClause(QueryOperator::Sort, [$sortMethod, $key]);
    }

    public static function limit(int $limit = 0, ?int $offset = 0) : QueryClause
    {
        return new QueryClause(QueryOperator::Limit, [$limit, $offset]);
    }

}
?>