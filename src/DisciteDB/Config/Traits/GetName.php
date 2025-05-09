<?php
namespace DisciteDB\Config\Traits;

trait GetName
{   
    public function getName() : string|null
    {
        return $this->name ?? null;
    }
}

?>