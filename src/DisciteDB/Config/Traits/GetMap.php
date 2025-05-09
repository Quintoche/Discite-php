<?php
namespace DisciteDB\Config\Traits;

trait GetMap
{   
    public function getMap() : array|null
    {
        return $this->map ?? null;
    }
}

?>