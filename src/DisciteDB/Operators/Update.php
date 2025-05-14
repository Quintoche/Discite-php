<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryStructure;
use DisciteDB\Core\QueryManager;

trait Update
{
    public function update(string|int|array $uuid, array $args)
    {
        foreach($args as $argKey => $argValue)
        {
            $key = $this->returnKey($argKey);
            
            if(!$key->validateField(Operators::Update,$argValue))
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
                $keyClass->validateField(Operators::Update,null);
                $args[$keyName] = $keyClass->generateField();
            }
        }

        if(is_array($uuid))
        {
            $uuidKey = array_keys($uuid)[0];
            $uuidValue = array_values($uuid)[0];
        }
        else
        {
            $uuidKey = $this->getIndexKey()->getName();
            $uuidValue = $uuid;
        }

        $this->query->setOperator(Operators::Update);
        $this->query->setArgs($args);
        $this->query->setUuid([$uuidKey => $uuidValue]);

        return $this->query->makeQuery();
    }
}

?>