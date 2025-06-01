<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\QueryResult;

trait Update
{
    public function update(string|int|array $uuid, array $args) : QueryResult
    {
        foreach($args as $argKey => $argValue)
        {
            $key = $this->returnKey($argKey);
            
            if(is_null($key))
            {
                unset($args[$argKey]);
                continue;
            }

            if(!$key->validateField(Operators::Update,$argValue))
            {
                unset($args[$argKey]);
                continue;
            }
            
            $args[$argKey] = $key->generateField();
        }
    
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

        
        $this->query->setOperator(Operators::Update);
        $this->query->setArgs($args);
        $this->query->setUuid([$uuidKey => $uuidValue]);

        return $this->query->makeQuery();
    }
}

?>