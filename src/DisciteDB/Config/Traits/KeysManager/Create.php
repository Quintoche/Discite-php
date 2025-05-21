<?php

namespace DisciteDB\Config\Traits\KeysManager;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\DisciteDB;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Keys\CustomKey;
use DisciteDB\Tables\BaseTable;

trait Create
{
    public function add(string $name, ?string $alias = null, ?string $prefix = null, TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type = TypeString::String, IndexType $index = DisciteDB::INDEX_TYPE_NONE, ?BaseTable $indexTable = null,mixed $default = DisciteDB::DEFAULT_VALUE_EMPTY_STRING, bool $nullable = false, bool $secure = false, bool $updatable = true) : BaseKey
    {
        $class = $this->createInitializeKey($name);

        $class->setName($name);
        if($alias) $class->setAlias($alias);
        if($prefix) $class->setPrefix($prefix);

        $class->setType($type);
        $class->setIndex($index);
        if($indexTable) $class->setIndexTable($indexTable);

        if($default) $class->setDefault($default);

        if($nullable) $class->setNullable($nullable);
        if($secure) $class->setSecure($secure);
        if($updatable) $class->setUpdatable($updatable);

        $this->createAppendTable($name,$class);

        return $class;
    }

    protected function createAppendTable(string $selectedName, BaseKey $class) : void
    {
        $this->registerKey($selectedName, $class);
    }

    protected function createInitializeKey(string $keyName)
    {
        $class = $this->returnTemplateKeys($keyName);
        return ($class == 'null') ? (new $class) : new CustomKey($this->database);
    }

}

?>