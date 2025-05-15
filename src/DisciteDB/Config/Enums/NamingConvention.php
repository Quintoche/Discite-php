<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of naming convention.
 *
 * This enum is used to choose between which convention you want to apply:
 * - CamelCase: Words are not separated. Each word except the first starts with an uppercase letter.
 * - PascalCase: Words are not separated. Each word starts with an uppercase letter.
 * - SnakeCase: Words are separated by underscores. All words are lowercase.
 * - SnakeUpperCase: Words are separated by underscores. All words are uppercase.
 * - Undefined: Words will not be formated.
 *
 * @enum
 */
enum NamingConvention : int 
{
    /** 
     * __camelCase__
     * 
     * Words are not separated. Each word except the first starts with an uppercase letter.
    */
    case CamelCase = 301;

    /** 
     * __PascalCase__
     * 
     * Words are not separated. Each word starts with an uppercase letter.
    */
    case PascalCase = 302;

    /** 
     * __snake_case__
     * 
     * Words are separated by underscores. All words are lowercase.
    */
    case SnakeCase = 303;

    /** 
     * __SNAKE_CASE_UPPERCASE__
     * 
     * Words are separated by underscores. All words are uppercase.
    */
    case SnakeUpperCase = 304;

    /** 
     * __Undefined__
     * 
     * Words will not be formated.
    */
    case Undefined = 305;
}
?>