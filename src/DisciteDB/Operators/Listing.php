<?php

namespace DisciteDB\Operators;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryStructure;
use DisciteDB\Core\QueryManager;

trait Listing
{
    public function listing(array $args)
    {
        

        foreach($args as $argKey => $argValue)
        {
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

            if(!array_key_exists($argKey,$this->getMap() ?? []))
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