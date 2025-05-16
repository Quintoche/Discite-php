<?php
namespace DisciteDB\Tables;

use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Utilities\NameSanitizer;

trait TableTraitSet
{
    public function setName(string $name) : void
    {
        if($this->name != null) return;
        $this->name = NameSanitizer::sanitize($name);
    }

    public function setAlias(?string $alias) : void
    {
        $this->alias = NameSanitizer::sanitize($alias);
    }

    public function setPrefix(?string $prefix) : void
    {
        $this->prefix = $prefix;
    }

    public function setIndexKey(BaseKey|null $key) : void
    {
        $this->indexKey = $key ?? null;
    }

    public function setSort(QuerySort $sort) : void
    {
        $this->sort = $sort ?? null;
    }

    public function setMagicValue(string $key, mixed $value) : void
    {
        if(property_exists($this, $key))
        {
            $this->{$key} = $value;
        }
    }
}

?>