<?php
namespace DisciteDB\Config\Traits;

trait GetUpdatable
{   
    public function getUpdatable() : bool|null
    {
        return $this->updatable ?? null;
    }
}

?>