<?php

namespace DisciteDB\Config\Enums;

/**
 * Common SQL default values.
 *
 * This enum defines standardized SQL default value constants
 * that can be reused during column creation. You can choose between :
 * - Null: NULL value (default SQL behavior).
 * - CurrentTimestamp: CURRENT_TIMESTAMP (e.g. for DATETIME, TIMESTAMP columns).
 * - Zero: Zero for numeric types.
 * - EmptyString: Empty string for string types.
 * - UUIDv4: UUID generator default (handled in PHP callback, fallback).
 * - Now: Now (alias for CURRENT_TIMESTAMP for consistency).
 * 
 * @enum
 */
enum DefaultValue : int
{
    /** 
     * __Null__
     * 
     * NULL value (default SQL behavior) 
    */
    case Null = 570;

    /** 
     * __CurrentTimestamp__
     * 
     * CURRENT_TIMESTAMP (e.g. for DATETIME, TIMESTAMP columns) 
    */
    case CurrentTimestamp = 571;

    /** 
     * __Zero__
     * 
     * Zero for numeric types 
    */
    case Zero = 572;

    /** 
     * __EmptyString__
     * 
     * Empty string for string types 
    */
    case EmptyString = 573;

    /** 
     * __UUIDv4__
     * 
     * UUID generator default (handled in PHP callback, fallback) 
    */
    case UUIDv4 = 574;

    /** 
     * __Now__
     * 
     * Now (alias for CURRENT_TIMESTAMP for consistency) 
    */
    case Now = 575;



    public static function getValue(string $value) : int
    {
        foreach(self::cases() as $status)
        {
            if( $value === $status->name ){
                return $status->value;
            }
        }
        return 0;
    }
}
?>