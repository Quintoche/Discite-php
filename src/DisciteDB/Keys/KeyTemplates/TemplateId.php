<?php

namespace DisciteDB\Keys\KeyTemplates;

use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

use DisciteDB\Keys\BaseKey;

final class TemplateId extends BaseKey
{
    
    protected ?string $name = 'id';
    
    protected ?string $alias = 'id';
    
    protected ?string $prefix = null;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type = TypeInteger::BigInt;

    protected IndexType $index = IndexType::Primary;

    protected mixed $default = DefaultValue::Null;

    protected bool $nullable = true;

    protected bool $secure = false;

    protected bool $updatable = false;

    protected array $map;

}

?>