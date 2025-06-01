<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Retrieve
{
    public function retrieve(string|int|array $uuid) : QueryResult
    {
        if(is_array($uuid))
        {
            $uuidKey = array_keys($uuid)[0];
            $uuidValue = array_values($uuid)[0];
        }
        else
        {
            $uuidKey = $this->getPrimaryKey()->getName() ?? 'id';
            $uuidValue = $uuid;
        }

        
        $this->query->setOperator(Operators::Retrieve);
        $this->query->setArgs([]);
        $this->query->setUuid([$uuidKey => $uuidValue]);

        return $this->query->makeQuery();
    }
}

?>