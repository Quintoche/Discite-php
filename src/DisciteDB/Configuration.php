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
use DisciteDB\Config\Enums\ValuesCharset;
use DisciteDB\Config\Enums\ValuesCollation;

/**
 * Class Configuration
 * 
 * Manages the configuration parameters for the database including charset, collation,
 * naming conventions, table usage, key usage, and type lengths.
 * Provides setters and getters for all configurable properties.
 * 
 * @package DisciteDB
 */
class Configuration
{
    /**
     * @var Database The Database instance this configuration belongs to.
     */
    private Database $database;

    
    /**
     * Configuration constructor.
     * 
     * @param Database $database The Database instance associated with this configuration.
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }


    /**
     * Set the character set for database encoding.
     * 
     * Defaults to CHARSET_UTF8MB4.
     * 
     * Available charsets:
     * - ValuesCharset::CHARSET_UTF8
     * - ValuesCharset::CHARSET_UTF8MB4
     * 
     * @param ValuesCharset $charset Character set to use.
     * 
     * @return void
     */
    public function setCharset(ValuesCharset $charset) : void
    {
        ValuesConfig::$CHARSET = $charset;
    }


    /**
     * Get the current character set used.
     * 
     * Defaults to CHARSET_UTF8MB4.
     * 
     * @return ValuesCharset Current charset setting.
     */
    public function getCharset(): ValuesCharset
    {
        return ValuesConfig::$CHARSET;
    }


    /**
     * Set the collation for database encoding.
     * 
     * Defaults to COLLATION_UTF8MB4_UNICODE_CI.
     * 
     * Available collations:
     * - ValuesCollation::COLLATION_UTF8MB4_GENERAL_CI
     * - ValuesCollation::COLLATION_UTF8MB4_UNICODE_CI
     * - ValuesCollation::COLLATION_UTF8MB4_BIN
     * 
     * @param ValuesCollation $collation Collation setting.
     * 
     * @return void
     */
    public function setCollation(ValuesCollation $collation) : void
    {
        ValuesConfig::$COLLATION = $collation;
    }


    /**
     * Get the current collation setting.
     * 
     * Defaults to COLLATION_UTF8MB4_UNICODE_CI.
     * 
     * @return ValuesCollation Current collation.
     */
    public function getCollation() : ValuesCollation
    {
        return ValuesConfig::$COLLATION;
    }


    /**
     * Set the naming convention used in database object names.
     * 
     * Default is NAMING_CONVENTION_UNDEFINED.
     * 
     * Supported conventions include:
     * - NamingConvention::NAMING_CONVENTION_UNDEFINED
     * - NamingConvention::NAMING_CONVENTION_CAMEL_CASE
     * - (Other conventions as defined in NamingConvention enum)
     * 
     * @param NamingConvention $naming Naming convention enum.
     * 
     * @return void
     */
    public function setNamingConvention(NamingConvention $naming) : void
    {
        NamingConfig::$NAMING_CASE = $naming;
    }


    /**
     * Get the current naming convention.
     * 
     * Defaults to NAMING_CONVENTION_UNDEFINED.
     * 
     * @return NamingConvention Current naming convention enum.
     */
    public function getNamingConvention() : NamingConvention
    {
        return NamingConfig::$NAMING_CASE;
    }


    /**
     * Get the current table usage mode.
     * 
     * @return TableUsage Enum representing table usage mode.
     */
    public function getTableUsage() : TableUsage
    {
        return UsageConfig::$TABLE_USAGE;
    }


    /**
     * Set the table usage mode.
     * 
     * @param TableUsage $tableUsage Table usage enum.
     * 
     * @return void
     */
    public function setTableUsage(TableUsage $tableUsage) : void
    {
        UsageConfig::$TABLE_USAGE = $tableUsage;
    }

    /**
     * Get the current key usage mode.
     * 
     * @return KeyUsage Enum representing key usage mode.
     */
    public function getKeyusage() : KeyUsage
    {
        return UsageConfig::$KEY_USAGE;
    }


    /**
     * Set the key usage mode.
     * 
     * @param KeyUsage $keyUsage Key usage enum.
     * 
     * @return void
     */
    public function setKeyusage(KeyUsage $keyUsage) : void
    {
        UsageConfig::$KEY_USAGE = $keyUsage;
    }

    
    /**
     * Set the length for a specific data type.
     * 
     * Supports string, date, float, integer, and binary types.
     * 
     * @param TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type Data type enum.
     * @param int $length Desired length for the type.
     * 
     * @return void
     */
    public function setTypeLength(TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type, int $length) : void
    {
        TypeConfig::$LENGTH_MAP[$type] = $length;
    }

    
    /**
     * Get the length for a specific data type.
     * 
     * @param TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type Data type enum.
     * 
     * @return int Length configured for this data type.
     */
    public function getTypeLength(TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type) : ?int
    {
        return TypeConfig::$LENGTH_MAP[$type] ?? null;
    }
}

?>
