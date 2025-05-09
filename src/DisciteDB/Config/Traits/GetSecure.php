<?php
namespace DisciteDB\Config\Traits;

trait GetSecure
{   
    public function getSecure() : bool|null
    {
        return $this->secure ?? null;
    }
}

?>