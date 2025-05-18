<?php

namespace DisciteDB\Methods;

use DisciteDB\Config\Enums\QueryOperator;
use DisciteDB\Users\BaseUser;

class QueryMethod
{

    public static function Async(?BaseUser $user) : QueryMethodExpression
    {
        return new QueryMethodExpression(QueryOperator::Async,[$user]);
    }

}
?>