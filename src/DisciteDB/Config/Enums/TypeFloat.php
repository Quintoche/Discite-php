<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of supported floating-point types.
 *
 * These are used for numeric fields requiring decimals. You can choose between :
 * - Float: Standard floating-point number.
 * - Double: Double-precision number.
 * - Decimal: Fixed-point number with high precision (useful for currency).
 * 
 * @enum
 */
enum TypeFloat : int
{

    /**
     * __Float__
     * 
     * Standard floating-point number.
     */
    case Float = 530;

    /**
     * __Double__
     * 
     * Double-precision number.
     */
    case Double = 531;

    /**
     * __Decimal__
     * 
     * Fixed-point number with high precision (useful for currency).
     */
    case Decimal = 532;
}
?>