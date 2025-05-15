<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of supported string types.
 *
 * This enum defines various text-based SQL types that you can assign
 * to fields. These are commonly used for short labels, long content,
 * slugs, tokens, etc. You can choose between :
 * - String: Standard short string (VARCHAR).
 * - SmallText: Text for small textual content.
 * - MediumText: Medium text for longer values.
 * - LongText: Long text for very large content like article bodies.
 * - UUID: Unique identifier string (like UUID).
 * - Email: Email string format.
 * - URL: URL string format.
 * - IP: IP string format.
 * - Username: username string format.
 * - Password: Password string format.
 * 
 * @enum
 */
enum TypeString : int
{

    /**
     * __String__
     * 
     * Standard short string (VARCHAR).
     */
    case String = 510;

    /**
     * __SmallText__
     * 
     * Text for small textual content.
     */
    case SmallText = 511;

    /**
     * __MediumText__
     * 
     * Medium text for longer values.
     */
    case MediumText = 512;

    /**
     * __LongText__
     * 
     * Long text for very large content like article bodies.
     */
    case LongText = 513;

    /**
     * __UUID__
     * 
     * Unique identifier string (like UUID).
     */
    case UUID = 514;

    /**
     * __Email__
     * 
     * Email string format.
     */
    case Email = 515;

    /**
     * __URL__
     * 
     * URL string format.
     */
    case URL = 516;

    /**
     * __IP__
     * 
     * IP string format.
     */
    case IP = 517;

    /**
     * __Username__
     * 
     * username string format.
     */
    case Username = 518;

    /**
     * __Password__
     * 
     * Password string format.
     */
    case Password = 519;
}
?>