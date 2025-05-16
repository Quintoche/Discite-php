<?php

namespace DisciteDB\Operators;

use DisciteDB\QueryHandler\QueryResult;

trait Compare
{
    public function compare() : QueryResult
    {
        return $this->query;
    }
}

?>