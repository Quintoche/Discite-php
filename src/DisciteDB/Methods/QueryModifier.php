<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Config\Enums\QuerySort;

class QueryModifier
{
    /**
     * Build one or more ORDER BY clauses.
     *
     * @param  array  ...$pairs  Each pair is [QuerySort, BaseKey|string]
     * @return QueryModifierExpression
     */
    public static function Order(array ...$pairs) : QueryModifierExpression
    {
        $args = self::validatePairs($pairs);
        return new QueryModifierExpression(QueryOperator::Sort, $args);
    }

    /**
     * Build one or more ORDER BY clauses.
     *
     * @param  array  ...$pairs  Each pair is [QuerySort, BaseKey|string]
     * @return QueryModifierExpression
     */
    public static function Sort(array ...$pairs) : QueryModifierExpression
    {
        $args = self::validatePairs($pairs);
        return new QueryModifierExpression(QueryOperator::Sort, $args);
    }

    public static function Limit(int $limit, ?int $offset = 0) : QueryModifierExpression
    {
        return new QueryModifierExpression(QueryOperator::Limit, [$limit, $offset]);
    }


    private static function validatePairs(array $pairs) : array
    {
        foreach ($pairs as $i => $pair) {
            if (count($pair) !== 2) {
                throw new \InvalidArgumentException(
                    "Sort() pair #{$i} must be [QuerySort, key]"
                );
            }
            list($sortMethod, $key) = $pair;
            if (! $sortMethod instanceof QuerySort) {
                throw new \InvalidArgumentException(
                    "Sort() pair #{$i} first element must be a QuerySort enum"
                );
            }
        }

        return $pairs;
    }
}
?>