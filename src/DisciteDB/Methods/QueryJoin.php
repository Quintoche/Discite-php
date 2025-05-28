<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Tables\BaseTable;

class QueryJoin
{

    public static function On(BaseTable|string $table) : QueryMethodExpression
    {
        return new QueryMethodExpression(QueryOperator::Async,[$table]);
    }

}
?>