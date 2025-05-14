<?php
namespace DisciteDB\Keys;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Tables\BaseTable;
use DisciteDB\Utilities\NameSanitizer;

trait KeyTraitSet
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

    public function setType(TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary|null $type) : void
    {
        $this->type = $type ?? TypeString::String;
    }

    public function setIndex(IndexType|null $index) : void
    {
        $this->index = $index ?? IndexType::None;
    }

    public function setIndexTable(BaseTable|null $table) : void
    {
        $this->indexTable = $table ?? null;
    }

    public function setDefault(mixed $default) : void
    {
        $this->default = $default;
    }

    public function setNullable(bool $nullable) : void
    {
        $this->nullable = $nullable;
    }

    public function setSecure(bool $secure) : void
    {
        $this->secure = $secure;
    }

    public function setUpdatable(bool $updatable) : void
    {
        $this->updatable = $updatable;
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