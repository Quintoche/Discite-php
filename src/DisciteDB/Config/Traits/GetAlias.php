<?php
namespace DisciteDB\Config\Traits;

trait GetAlias
{   
    public function getAlias() : string|null
    {
        return $this->alias ?? null;
    }
}

?>