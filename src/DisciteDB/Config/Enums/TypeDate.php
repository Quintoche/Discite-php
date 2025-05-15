<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of supported date/time types.
 *
 * This enum groups all types of temporal data handled by SQL and PHP. You can choose between :
 * - Date: Date only (YYYY-MM-DD).
 * - Time: Time only (HH:MM:SS).
 * - DateTime: Full date and time (YYYY-MM-DD HH:MM:SS).
 * - Timestamp: Timestamp (numeric UNIX time).
 * - Year: Year only (YYYY).
 * 
 * @enum
 */
enum TypeDate : int
{

    /**
     * __Date__
     * 
     * Date only (YYYY-MM-DD).
     */
    case Date = 520;

    /**
     * __Time__
     * 
     * Time only (HH:MM:SS).
     */
    case Time = 521;

    /**
     * __DateTime__
     * 
     * Full date and time (YYYY-MM-DD HH:MM:SS).
     */
    case DateTime = 522;

    /**
     * __Timestamp__
     * 
     * Timestamp (numeric UNIX time).
     */
    case Timestamp = 523;

    /**
     * __Year__
     * 
     * Year only (YYYY).
     */
    case Year = 524;
}
?>