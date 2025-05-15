<?php

namespace DisciteDB;

use DisciteDB\Config\Enums\ValuesCharset;
use DisciteDB\Config\Enums\NamingConvention;
use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Config\Enums\ValuesCollation;

/**
 * Class DisciteDB
 *
 * Central class to expose internal enums and configurations as constants.
 * This avoids forcing the user to import many individual enums with "use".
 *
 * @package DisciteDB
 */
class DisciteDB
{


    /* === Charsets === */


    /**
     * UTF-8 charset with 3 bytes encoding (utf8mb3).
     * Escapes emojis.
     *
     * @var ValuesCharset
     */
    public const CHARSET_UTF8 = ValuesCharset::Utf8;


    /**
     * UTF-8 charset with 4 bytes encoding (utf8mb4).
     * Supports full Unicode including emojis without escaping.
     *
     * @var ValuesCharset
     */
    public const CHARSET_UTF8MB4 = ValuesCharset::Utf8mb4;



    /* === Collation === */


    /**
     * 
     * 
     *
     * @var ValuesCollation
     */
    public const COLLATION_UTF8MB4_GENERAL_CI = ValuesCollation::Utf8mb4_general_ci;


    /**
     * 
     * 
     *
     * @var ValuesCollation
     */
    public const COLLATION_UTF8MB4_UNICODE_CI = ValuesCollation::Utf8mb4_unicode_ci;


    /**
     * 
     * 
     *
     * @var ValuesCollation
     */
    public const COLLATION_UTF8MB4_BIN = ValuesCollation::Utf8mb4_bin;



    /* === Naming Conventions === */


    /**
     * Undefined naming convention.
     *
     * @var NamingConvention
     */
    public const NAMING_CONVENTION_UNDEFINED = NamingConvention::Undefined;


    /**
     * CamelCase naming convention.
     * Example: myFieldName
     *
     * @var NamingConvention
     */
    public const NAMING_CONVENTION_CAMEL_CASE = NamingConvention::CamelCase;


    /**
     * PascalCase naming convention.
     * Example: MyFieldName
     *
     * @var NamingConvention
     */
    public const NAMING_CONVENTION_PASCAL_CASE = NamingConvention::PascalCase;


    /**
     * snake_case naming convention.
     * Example: my_field_name
     *
     * @var NamingConvention
     */
    public const NAMING_CONVENTION_SNAKE_CASE = NamingConvention::SnakeCase;


    /**
     * SNAKE_UPPERCASE naming convention.
     * Example: MY_FIELD_NAME
     *
     * @var NamingConvention
     */
    public const NAMING_CONVENTION_SNAKE_UPPERCASE = NamingConvention::SnakeUpperCase;



    /* === Table Usage === */


    /**
     * Strict table usage mode.
     * Keys must be defined before use.
     *
     * @var TableUsage
     */
    public const TABLE_USAGE_STRICT = TableUsage::StrictUsage;


    /**
     * Loose table usage mode.
     * Keys do not need to be defined before use.
     *
     * @var TableUsage
     */
    public const TABLE_USAGE_LOOSE = TableUsage::LooseUsage;



    /* === Key Usage === */


    /**
     * Strict table usage mode.
     * Keys must be defined before use.
     *
     * @var KeyUsage
     */
    public const KEY_USAGE_STRICT = KeyUsage::StrictUsage;


    /**
     * Loose table usage mode.
     * Keys do not need to be defined before use.
     *
     * @var KeyUsage
     */
    public const KEY_USAGE_LOOSE = KeyUsage::LooseUsage;



    /* === Default SQL Values === */


    /**
     * SQL NULL default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_NULL = DefaultValue::Null;


    /**
     * SQL CURRENT_TIMESTAMP default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_CURRENT_TIMESTAMP = DefaultValue::CurrentTimestamp;


    /**
     * Numeric zero default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_ZERO = DefaultValue::Zero;


    /**
     * Empty string default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_EMPTY_STRING = DefaultValue::EmptyString;


    /**
     * UUID version 4 default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_UUIDV4 = DefaultValue::UUIDv4;


    /**
     * NOW() function default value.
     *
     * @var DefaultValue
     */
    public const DEFAULT_VALUE_NOW = DefaultValue::Now;



    /* === SQL Index Types === */


    /**
     * No index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_NONE = IndexType::None;


    /**
     * Regular index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_INDEX = IndexType::Index;


    /**
     * Unique index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_UNIQUE = IndexType::Unique;


    /**
     * Primary key index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_PRIMARY = IndexType::Primary;


    /**
     * Full-text index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_FULLTEXT = IndexType::FullText;


    /**
     * Spatial index.
     *
     * @var IndexType
     */
    public const INDEX_TYPE_SPATIAL = IndexType::Spatial;


    /* === Query Location (for Contains / NotContains) === */


    /**
     * Query location - starts with.
     *
     * @var QueryLocation
     */
    public const QUERY_LOCATION_STARTWITH = QueryLocation::StartWith;


    /**
     * Query location - ends with.
     *
     * @var QueryLocation
     */
    public const QUERY_LOCATION_ENDWITH = QueryLocation::EndWith;


    /**
     * Query location - contains (between).
     *
     * @var QueryLocation
     */
    public const QUERY_LOCATION_BETWEEN = QueryLocation::Between;



    /* === Binary / Structured Data Types === */


    /**
     * Binary Blob type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_BLOB = TypeBinary::Blob;


    /**
     * Binary TinyBlob type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_TINYBLOB = TypeBinary::TinyBlob;


    /**
     * Binary MediumBlob type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_MEDIUMBLOB = TypeBinary::MediumBlob;


    /**
     * Binary LongBlob type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_LONGBLOB = TypeBinary::LongBlob;


    /**
     * Binary JSON type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_JSON = TypeBinary::Json;


    /**
     * Binary File type.
     *
     * @var TypeBinary
     */
    public const TYPE_BINARY_FILE = TypeBinary::File;



    /* === Date / Time Types === */


    /**
     * Date type.
     *
     * @var TypeDate
     */
    public const TYPE_DATE_DATE = TypeDate::Date;


    /**
     * Time type.
     *
     * @var TypeDate
     */
    public const TYPE_DATE_TIME = TypeDate::Time;


    /**
     * DateTime type.
     *
     * @var TypeDate
     */
    public const TYPE_DATE_DATETIME = TypeDate::DateTime;


    /**
     * Timestamp type.
     *
     * @var TypeDate
     */
    public const TYPE_DATE_TIMESTAMP = TypeDate::Timestamp;


    /**
     * Year type.
     *
     * @var TypeDate
     */
    public const TYPE_DATE_YEAR = TypeDate::Year;



    /* === Floating Point Types === */


    /**
     * Float type.
     *
     * @var TypeFloat
     */
    public const TYPE_FLOAT_FLOAT = TypeFloat::Float;


    /**
     * Double type.
     *
     * @var TypeFloat
     */
    public const TYPE_FLOAT_DOUBLE = TypeFloat::Double;


    /**
     * Decimal type.
     *
     * @var TypeFloat
     */
    public const TYPE_FLOAT_DECIMAL = TypeFloat::Decimal;



    /* === Integer Types === */


    /**
     * Boolean type (stored as integer).
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_BOOLEAN = TypeInteger::Boolean;


    /**
     * Integer type.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_INT = TypeInteger::Integer;


    /**
     * BigInt type.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_BIGINT = TypeInteger::BigInt;


    /**
     * TinyInt type.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_TINYINT = TypeInteger::TinyInt;


    /**
     * MediumInt type.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_MEDIUMINT = TypeInteger::MediumInt;


    /**
     * SmallInt type.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_SMALLINT = TypeInteger::SmallInt;


    /**
     * Unix timestamp stored as integer.
     *
     * @var TypeInteger
     */
    public const TYPE_INTEGER_UNIXTIME = TypeInteger::UnixTime;


    
    /* === String Types === */


    /**
     * String type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_STRING = TypeString::String;


    /**
     * SmallText type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_SMALLTEXT = TypeString::SmallText;


    /**
     * MediumText type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_MEDIUMTEXT = TypeString::MediumText;


    /**
     * LongText type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_LONGTEXT = TypeString::LongText;


    /**
     * UUID string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_UUID = TypeString::UUID;


    /**
     * Email string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_EMAIL = TypeString::Email;


    /**
     * URL string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_URL = TypeString::URL;


    /**
     * IP address string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_IP = TypeString::IP;


    /**
     * Username string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_USERNAME = TypeString::Username;


    /**
     * Password string type.
     *
     * @var TypeString
     */
    public const TYPE_STRING_PASSWORD = TypeString::Password;
}
