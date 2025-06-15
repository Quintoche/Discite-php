<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Create
{
    public function create(array $args) : QueryResult
    {
        $this->query->setOperator(Operators::Create);
        $this->query->setArgs($args);

        return $this->query->makeQuery();

    }
}

?>