<?php

namespace DisciteDB\Keys\KeyTemplates;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

use DisciteDB\Keys\BaseKey;

final class TemplatePassword extends BaseKey
{
    
    protected ?string $name = 'password';
    
    protected ?string $alias = 'password';
    
    protected ?string $prefix = null;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type = TypeString::Password;

    protected IndexType $index = IndexType::None;

    protected mixed $default = null;

    protected bool $nullable = false;

    protected bool $secure = true;

    protected bool $updatable = true;

    protected array $map;

}

?>