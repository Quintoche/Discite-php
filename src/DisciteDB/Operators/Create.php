<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;

trait Create
{
    public function create(array $args)
    {
        foreach($args as $argKey => $argValue)
        {
            $key = $this->tableManager->returnKey($argKey);
            
            if(!$key->validateField(Operators::Create,$argValue))
            {
                unset($args[$argKey]);
                continue;
            }
            
            $args[$argKey] = $key->generateField();
        }
        
        
        foreach($this->getMap() ?? [] as $keyName => $keyClass)
        {
            if(!array_key_exists($keyName,$args))
            {
                $keyClass->validateField(Operators::Create,null);
                $args[$keyName] = $keyClass->generateField();
            }
        }

    }
}

?>