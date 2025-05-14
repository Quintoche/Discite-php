<?php
namespace DisciteDB\tables;

use DisciteDB\Keys\BaseKey;

trait TableTraitMap
{
    public function appendKey(BaseKey $key) : void
    {
        $this->map[$key->getAlias() ?? $key->getName()] = $key;
    }

    public function revokeKey(BaseKey $key) : void
    {
        unset($this->map[$key->getAlias() ?? $key->getName()]);
    }

    public function returnKey(string $keyName) : ?BaseKey
    {
        return $this->map[$keyName] ?? null;
    }
}

?>