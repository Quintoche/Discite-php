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

final class TemplateToken extends BaseKey
{
    
    protected ?string $name = 'token';
    
    protected ?string $alias = 'token';
    
    protected ?string $prefix = null;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type = TypeString::UUID;

    protected IndexType $index = IndexType::Unique;

    protected mixed $default = DefaultValue::UUIDv4;

    protected bool $nullable = false;

    protected bool $secure = false;

    protected bool $updatable = false;

    protected array $map;

}

?>