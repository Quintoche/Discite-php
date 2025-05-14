<?php
namespace DisciteDB;

use DisciteDB\Config\Default\NamingConfig;
use DisciteDB\Config\Default\TypeConfig;
use DisciteDB\Config\Default\UsageConfig;
use DisciteDB\Config\Default\ValuesConfig;

use DisciteDB\Config\Enums\NamingConvention;
use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class Configuration
{

    private Database $database;


    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function setCharset(string $charset) : void
    {
        ValuesConfig::$CHARSET = $charset;
    }
    
    public function setNamingConvention(NamingConvention $naming) : void
    {
        NamingConfig::$NAMING_CASE = $naming;
    }

    public function setTableUsage(TableUsage $tableUsage) : void
    {
        UsageConfig::$TABLE_USAGE = $tableUsage;
    }

    public function setKeyusage(KeyUsage $keyUsage) : void
    {
        UsageConfig::$KEY_USAGE = $keyUsage;
    }

    public function setTypeLength(TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type, int $length) : void
    {
        TypeConfig::$LENGTH_MAP[$type] = $length;
    }

    public function getTypeLength(TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type) : ?int
    {
        return TypeConfig::$LENGTH_MAP[$type] ?? null;
    }
}

?>