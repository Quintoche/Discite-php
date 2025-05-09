<?php
namespace DisciteDB\Tables;

use DisciteDB\Connection;

use DisciteDB\Config\Traits\AppendKey;
use DisciteDB\Config\Traits\RevokeKey;
use DisciteDB\Config\Traits\UpdateVariable;
use DisciteDB\Config\Traits\GetName;
use DisciteDB\Config\Traits\GetAlias;
use DisciteDB\Config\Traits\GetPrefix;
use DisciteDB\Config\Traits\GetMap;

use DisciteDB\Operators\All;
use DisciteDB\Operators\Compare;
use DisciteDB\Operators\Count;
use DisciteDB\Operators\Create;
use DisciteDB\Operators\Delete;
use DisciteDB\Operators\Keys;
use DisciteDB\Operators\Listing;
use DisciteDB\Operators\Retrieve;
use DisciteDB\Operators\Update;

class Table
{
    use All, Compare, Count, Create, Update;
    use Delete, Keys, Listing, Retrieve;

    use AppendKey, RevokeKey, UpdateVariable;
    use GetName, GetAlias, GetPrefix, GetMap;

    protected Connection $connection;

    protected ?string $name = null;

    protected ?string $alias = null;

    protected ?string $prefix = null;

    protected array $map;

    public function __construct()
    {

    }
}

?>