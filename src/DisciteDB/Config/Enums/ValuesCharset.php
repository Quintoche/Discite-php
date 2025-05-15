<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of character set values.
 *
 * This enum defines character sets used for encoding strings:
 * - Utf8: UTF-8 encoding (3 bytes), escapes emojis.
 * - Utf8mb4: UTF-8 encoding (4 bytes), no escaping of emojis.
 * 
 * @enum
 */
enum ValuesCharset : int 
{
    /** 
     * __Utf8__
     * 
     * UTF-8 encoding (3 bytes), escapes emojis.
    */
    case Utf8 = 301;

    /** 
     * __Utf8mb4__
     * 
     * UTF-8 encoding (4 bytes), supports all Unicode characters without escaping.
    */
    case Utf8mb4 = 302;
}

?>