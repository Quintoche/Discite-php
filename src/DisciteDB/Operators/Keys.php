<?php

namespace DisciteDB\Operators;

use DisciteDB\QueryHandler\QueryResult;

trait Keys
{
    public function keys() : QueryResult
    {
        return $this->query;
    }
}

?>