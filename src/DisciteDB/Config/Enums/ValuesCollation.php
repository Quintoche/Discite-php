<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of Key usage.
 *
 * This enum is used to choose the way you want to use this librairie:
 * - StrictUsage: Keys have to be defined before used.
 * - LooseUsage: Keys shouldn't be defined before used.
 *
 * @enum
 */
enum ValuesCollation : int 
{
    /** 
     * __Utf8mb4_general_ci__
     * 
     * Utf8mb4_general_ci
    */
    case Utf8mb4_general_ci = 401;

    /** 
     * __Utf8mb4_unicode_ci__
     * 
     * Utf8mb4_unicode_ci
    */
    case Utf8mb4_unicode_ci = 402;

    /** 
     * __Utf8mb4_bin__
     * 
     * Utf8mb4_bin
    */
    case Utf8mb4_bin = 404;

}
?>