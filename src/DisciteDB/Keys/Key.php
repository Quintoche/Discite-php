<?php

namespace DisciteDB\Keys;

use DisciteDB\Config\Traits\AppendOperator;
use DisciteDB\Config\Traits\RevokeOperator;
use DisciteDB\Config\Traits\UpdateVariable;
use DisciteDB\Config\Traits\GetName;
use DisciteDB\Config\Traits\GetAlias;
use DisciteDB\Config\Traits\GetPrefix;
use DisciteDB\Config\Traits\getType;
use DisciteDB\Config\Traits\GetDefault;
use DisciteDB\Config\Traits\GetNullable;
use DisciteDB\Config\Traits\GetUpdatable;
use DisciteDB\Config\Traits\GetSecure;
use DisciteDB\Config\Traits\GetMap;
use DisciteDB\Connection;

class Key
{
    use AppendOperator, RevokeOperator, UpdateVariable;
    use GetName, GetAlias, GetPrefix, getType, GetDefault, GetNullable, GetSecure, GetUpdatable, GetMap;

    protected Connection $connection;

    protected ?string $name = null;
    
    protected ?string $alias = null;
    
    protected ?string $prefix = null;

    protected ?string $type = null;

    protected ?string $default = null;

    protected bool $nullable = false;

    protected bool $secure = false;

    protected bool $updatable = true;

    protected array $map;

    public function __construct()
    {
        
    }    
}

?>