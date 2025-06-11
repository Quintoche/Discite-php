<?php

namespace DisciteDB\Sql\Loading;

use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Database;
use DisciteDB\DisciteDB;
use DisciteDB\Keys\BaseKey;

class LoadingKeys
{
    public static function create(array $key, ?array $index ,Database $database) : BaseKey
    {
        return $database->keys()->add($key['table'].'_'.$key['name'],
            alias: $key['name'],
            type: self::returnType($key['type'],$key['length']),
            default: self::returnDefault($key),
            nullable: self::returnNullable($key['nullable']),
            updatable: self::returnUpdatable($key),
            index: self::returnIndex($key, $index),
            secure: false,  
        );
    }

    public static function isPrimaryKey(BaseKey $key) : bool
    {
        return ($key->getIndex() === IndexType::Primary);
    }

    private static function returnIndex(array $key, ?array $index)
    {
        if(!$index || empty($index)) return IndexType::None;

        if(!isset($index['constraint_name'])) $index['constraint_name'] = null;
        if(!isset($index['non_unique'])) $index['non_unique'] = null;
        if(!isset($index['index_type'])) $index['index_type'] = null;

        return match (true)
        {
            $key['extra'] == 'auto_increment'           => IndexType::Primary,
            $index['constraint_name'] === 'PRIMARY'     => IndexType::Primary,
            $index['non_unique'] === 0                  => IndexType::Unique,
            $index['index_type'] == 'FULLTEXT'          => IndexType::FullText,
            !is_null($index['referenced_table'])        => IndexType::Index,
            default                                     => IndexType::None,
        };
    }

    private static function returnIndexTable()
    {

    }

    private static function returnUpdatable(array $key) : mixed
    {
        return match (true) 
        {
            $key['extra'] == 'auto_increment'    => false,
            default                              => true,
        };
    }

    private static function returnDefault(?array $key) : mixed
    {
        $default = $key['default'];
        $isNullable = $key['nullable'];
        
        return match (true) 
        {
            $key['extra'] == 'auto_increment'            => DefaultValue::Null,
            is_null($default) && $isNullable == 'YES'    => DefaultValue::Null,
            $default == 'current_timestamp()'            => DefaultValue::CurrentTimestamp,
            $default == 'current_timestamp(3)'           => DefaultValue::CurrentTimestamp,
            $default == '0' && $isNullable == 'NO'       => DefaultValue::Zero,
            $default == 'UUID()'                         => DefaultValue::UUIDv4,
            $default == '' && $isNullable == 'NO'        => DefaultValue::EmptyString,
            is_null($default) && $isNullable == 'NO'     => DefaultValue::EmptyString,
            default                                      => $default,
        };
    }

    private static function returnNullable(string $isNullable) : bool
    {
        return match ($isNullable) {
            'YES'   => true,
            'NO'    => false,
            default => false,
        };
    }

    private static function returnType(string $type, ?int $length) : mixed
    {
        return match ($type) {
            'char'          => self::returnTypeString($length), 
            'varchar'       => self::returnTypeString($length), 
            'tinytext'      => DisciteDB::TYPE_STRING_SMALLTEXT, 
            'text'          => DisciteDB::TYPE_STRING_STRING, 
            'mediumtext'    => DisciteDB::TYPE_STRING_MEDIUMTEXT, 
            'longtext'      => DisciteDB::TYPE_STRING_LONGTEXT, 
            'enum'          => self::returnTypeString($length), 
            'set'           => self::returnTypeString($length),
            'tinyint'       => DisciteDB::TYPE_INTEGER_BOOLEAN,
            'smallint'      => DisciteDB::TYPE_INTEGER_SMALLINT,
            'mediumint'     => DisciteDB::TYPE_INTEGER_MEDIUMINT,
            'int'           => DisciteDB::TYPE_INTEGER_INT,
            'bigint'        => DisciteDB::TYPE_INTEGER_BIGINT,
            'float'         => DisciteDB::TYPE_FLOAT_FLOAT,
            'double'        => DisciteDB::TYPE_FLOAT_DOUBLE,
            'decimal'       => DisciteDB::TYPE_FLOAT_DECIMAL,
            'real'          => DisciteDB::TYPE_FLOAT_DOUBLE,
            'date'          => DisciteDB::TYPE_DATE_DATE,
            'datetime'      => DisciteDB::TYPE_DATE_DATETIME,
            'time'          => DisciteDB::TYPE_DATE_TIME,
            'timestamp'     => DisciteDB::TYPE_DATE_TIMESTAMP,
            'year'          => DisciteDB::TYPE_DATE_YEAR,
            'binary','blob' => self::returnTypeBlob($length),
            default         => DisciteDB::TYPE_STRING_STRING,
        };
    }

    private static function returnTypeString(?int $length) : TypeString
    {
        return match ($length) {
            100         => DisciteDB::TYPE_STRING_SMALLTEXT,
            255         => DisciteDB::TYPE_STRING_STRING,
            16777215    => DisciteDB::TYPE_STRING_MEDIUMTEXT,
            4294967295  => DisciteDB::TYPE_STRING_LONGTEXT,
            36          => DisciteDB::TYPE_STRING_UUID,
            default     => DisciteDB::TYPE_STRING_STRING,
        };
    }

    private static function returnTypeInteger(?int $length) : TypeInteger
    {
        return match ($length) {
            3         => DisciteDB::TYPE_INTEGER_TINYINT,
            5         => DisciteDB::TYPE_INTEGER_SMALLINT,
            8         => DisciteDB::TYPE_INTEGER_MEDIUMINT,
            10        => DisciteDB::TYPE_INTEGER_INT,
            20        => DisciteDB::TYPE_INTEGER_BIGINT,
            1         => DisciteDB::TYPE_INTEGER_BOOLEAN,
            10        => DisciteDB::TYPE_INTEGER_UNIXTIME,
            default   => DisciteDB::TYPE_INTEGER_INT,
        };
    }

    private static function returnTypeBlob(?int $length) : TypeBinary
    {
        return match ($length) {
            65535     => DisciteDB::TYPE_BINARY_BLOB,
            255       => DisciteDB::TYPE_BINARY_TINYBLOB,
            16777215  => DisciteDB::TYPE_BINARY_MEDIUMBLOB,
            429496729 => DisciteDB::TYPE_BINARY_LONGBLOB,
            65535     => DisciteDB::TYPE_BINARY_JSON,
            default   => DisciteDB::TYPE_BINARY_BLOB,
        };
    }
}

?>