<?php
namespace DisciteDB\Config\Traits;

trait GetNullable
{   
    public function getNullable() : bool|null
    {
        return $this->nullable ?? null;
    }
}

?>