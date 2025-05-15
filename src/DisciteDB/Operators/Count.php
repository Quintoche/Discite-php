<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Count
{
    public function count(array $args) : QueryResult
    {
        foreach($args as $argKey => $argValue)
        {
            $key = $this->returnKey($argKey);
            
            if(is_null($key))
            {
                unset($args[$argKey]);
                continue;
            }
            
            if(!$key->validateField(Operators::Count,$argValue))
            {
                unset($args[$argKey]);
                continue;
            }
            
            $args[$argKey] = $key->generateField();
        }

        $_selectedOperator = (sizeof($args) == 0) ? Operators::CountAll : Operators::Count;
        $this->query->setOperator($_selectedOperator);
        $this->query->setArgs($args);

        return $this->query->makeQuery();
    }
}

?>