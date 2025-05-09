<?php
namespace DisciteDB\Config\Traits;

trait GetDefault
{   
    public function getDefault() : string|null
    {
        return $this->default ?? null;
    }
}

?>