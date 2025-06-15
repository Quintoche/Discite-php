<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Count
{
    public function count(array $args) : QueryResult
    {
        $this->query->setOperator((sizeof($args) == 0) ? Operators::CountAll : Operators::Count);
        $this->query->setArgs($args);

        return $this->query->makeQuery();
    }
}

?>