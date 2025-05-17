<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Methods\QueryClause;
use DisciteDB\QueryHandler\QueryResult;

trait Listing
{
    public function listing(array $args) : QueryResult
    {
        foreach($args as $argKey => $argValue)
        {
            if($argValue instanceof QueryClause) continue;
            
            $key = $this->returnKey($argKey);
            

            if(is_null($key))
            {
                unset($args[$argKey]);
                continue;
            }

            if(!$key->validateField(Operators::Listing,$argValue))
            {
                unset($args[$argKey]);
                continue;
            }
            
            $args[$argKey] = $key->generateField();
        }

        $this->query->setOperator(Operators::Listing);
        $this->query->setArgs($args);

        return $this->query->makeQuery();
    }
}

?>