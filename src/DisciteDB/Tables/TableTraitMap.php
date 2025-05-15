<?php
namespace DisciteDB\tables;

use DisciteDB\Config\Enums\KeyUsage;
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
        if($this->database->config()->getKeyusage() === KeyUsage::LooseUsage)
        {
            return $this->database->keys()->create($keyName, ['alias' => $keyName,'looseUsage'=>true]);
        }
        else
        {
            return $this->map[$keyName] ?? null;
        }
    }
}

?>