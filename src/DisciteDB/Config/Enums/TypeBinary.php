<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of special storage types like binary and structured data.
 *
 * This enum defines types used for storing binary data (images, files, etc.). You can choose between :
 * - Blob: Binary Large Object – for large binary data (e.g. images, files).
 * - TinyBlob: Tiny binary data (up to 255 bytes).
 * - MediumBlob: Medium binary data (up to 16 MB).
 * - LongBlob: Long binary data (up to 4 GB).
 * - Json: JSON structured format – must be valid JSON.
 * - File: Default file element.
 * 
 * @enum
 */
enum TypeBinary : int
{
    
    /**
     * __Blob__
     * 
     * Binary Large Object – for large binary data (e.g. images, files).
     */
    case Blob = 540;

    /**
     * __TinyBlob__
     * 
     * Tiny binary data (up to 255 bytes).
     */
    case TinyBlob = 541;

    /**
     * __MediumBlob__
     * 
     * Medium binary data (up to 16 MB).
     */
    case MediumBlob = 542;

    /**
     * __LongBlob__
     * 
     * Long binary data (up to 4 GB).
     */
    case LongBlob = 543;

    /**
     * __Json__
     * 
     * JSON structured format – must be valid JSON.
     */
    case Json = 544;

    /**
     * __File__
     * 
     * Default blob file.
     */
    case File = 545;



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