<?php
namespace DisciteDB\Config\Traits;

use DisciteDB\Keys\Key;

trait RevokeKey
{   
    public function revokeKey(Key $key) : void
    {
        unset($this->map[$key->getAlias() ?? $key->getName()]);
    }
}

?>