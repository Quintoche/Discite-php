<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of SQL index types.
 *
 * Defines how a field should be indexed. You can choose between :
 * - None: No index.
 * - Index: Regular index.
 * - Unique: Unique index (no duplicate values).
 * - Primary: Primary key (only one per table).
 * - FullText: Fulltext index (for text search).
 * - Spatial: Spatial index (for geometry types).
 * 
 * @enum
 */
enum IndexType : int
{
    /** 
     * __None__
     * 
     * No index 
    */
    case None = 560;

    /** 
     * __Index__
     * 
     * Regular index 
    */
    case Index = 561;

    /** 
     * __Unique__
     * 
     * Unique index (no duplicate values) 
    */
    case Unique = 562;

    /** 
     * __Primary__
     * 
     * Primary key (only one per table) 
    */
    case Primary = 563;

    /** 
     * __FullText__
     * 
     * Fulltext index (for text search) 
    */
    case FullText = 564;

    /** 
     * __Spatial__
     * 
     * Spatial index (for geometry types) 
    */
    case Spatial = 565;



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