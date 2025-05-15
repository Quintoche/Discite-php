<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of supported integer types.
 *
 * This enum allows choosing between different commonly used integer types
 * for database fields. These types can be configured with default length
 * and behavior using the configuration API. You can choose between :
 * - Boolean: Boolean integer (O or 1), (false or true).
 * - Integer: Signed standard integer.
 * - BigInteger: Big integer, commonly used for IDs.
 * - TinyInteger: Tiny integer, used for small range values.
 * - MediumInteger: Medium integer, used for medium-range values.
 * - SmallInteger: Small integer, smaller than regular INT.
 *
 * @enum
 */
enum TypeInteger : int
{

    /**
     * __Boolean__
     * 
     * Boolean type (O or 1), (false or true).
     */
    case Boolean = 500;

    /**
     * __Integer__
     * 
     * Signed standard integer.
     */
    case Integer = 501;

    /**
     * __BigInt__
     * 
     * Big integer, commonly used for IDs.
     */
    case BigInt = 502;

    /**
     * __TinyInteger__
     * 
     * Tiny integer, used for small range values.
     */
    case TinyInt = 503;

    /**
     * __MediumInt__
     * 
     * Medium integer, used for medium-range values.
     */
    case MediumInt = 504;

    /**
     * __SmallInt__
     * 
     * Small int, smaller than regular INT.
     */
    case SmallInt = 505;

    /**
     * __UnixTime__
     * 
     * Unix time, Alternative to TypeDate::Timestamp.
     */
    case UnixTime = 506;
}
?>