<?php
namespace DisciteDB\Config\Traits;

trait GetPrefix
{   
    public function getPrefix() : string|null
    {
        return $this->prefix ?? null;
    }
}

?>