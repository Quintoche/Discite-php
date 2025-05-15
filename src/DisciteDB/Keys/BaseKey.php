<?php

namespace DisciteDB\Keys;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Connection;
use DisciteDB\Database;
use DisciteDB\Fields\FieldValidator;
use DisciteDB\Tables\BaseTable;

/**
 * Key.
 * 
 * This is the key class 
 * 
 * @method string|null getName() return Key name
 * @method string|null getAlias() return Key Alias
 * @method string|null getPrefix() return Key Prefix
 * @method TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary|null getType() return Key type
 *
 * @return BaseKey \DisciteDB\Keys\BaseKey
 */
abstract class BaseKey
{
    use KeyTraitGet, KeyTraitSet, KeyTraitMap;

    protected Database $database;

    protected Connection $connection;

    protected FieldValidator $field;

    protected ?string $name = null;
    
    protected ?string $alias = null;
    
    protected ?string $prefix = null;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type = TypeString::String;

    protected IndexType $index = IndexType::None;

    protected ?BaseTable $indexTable = null;

    protected mixed $default = null;

    protected bool $nullable = true;

    protected bool $secure = false;

    protected bool $updatable = true;

    protected bool $looseUsage = false;

    protected array $map;

    public function __construct(Database $database)
    {
        $this->database = $database;
        
        $this->connection = $this->database->connection();

        $this->field = new FieldValidator($this);
    } 
}

?>