<?php
namespace DisciteDB\Config\Traits;

trait UpdateVariable
{
    
    public function updateVariable(string $key, ?string $value) : void
    {
        if(property_exists($this, $key))
        {
            $this->{$key} = $value;
        }
    }
}

?>