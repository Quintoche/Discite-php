<?php
namespace DisciteDB\Config\Traits;

use DisciteDB\Keys\Key;

trait AppendKey
{   
    public function appendKey(Key $key) : void
    {
        $this->map[$key->getAlias() ?? $key->getName()] = $key;
    }
}

?>