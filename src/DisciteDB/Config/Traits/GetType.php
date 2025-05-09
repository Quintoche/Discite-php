<?php
namespace DisciteDB\Config\Traits;

trait getType
{   
    public function getType() : string|null
    {
        return $this->type ?? null;
    }
}

?>