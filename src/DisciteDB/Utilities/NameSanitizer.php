<?php

namespace DisciteDB\Utilities;

use DisciteDB\Config\Default\NamingConfig;
use DisciteDB\Config\Enums\NamingConvention;

/**
 * __Utilities class to sanitize string name__.
 *
 * This class used static methods to return a proper naming based on pre-defined naming convention wished.
 * 
 */
class NameSanitizer
{


    /**
     * 
     * Private variable used to set regex pattern.
     *
     * @var string $matchingRegex default : "/[A-Za-z0-9]+/"
     * 
     */
    private static string $matchingRegex = '/[A-Za-z0-9]+/';


    /**
     * __Main method to sanitize string__.
     * 
     * Method used to sanitize given string name.
     *
     * @param string $string
     * @param NamingConvention $naming __NamingConfig::NAMING_CASE__ is set as default 
     * 
     * @return string
     * 
     */ 
    public static function sanitize(string $string, ?NamingConvention $naming = null): string
    {
        $naming ??= NamingConfig::$NAMING_CASE;

        return match ($naming) {
            NamingConvention::CamelCase => self::returnCamelCase($string),
            NamingConvention::PascalCase => self::returnPascalCase($string),
            NamingConvention::SnakeCase => self::returnSnakeCase($string),
            NamingConvention::SnakeUpperCase => self::returnSnakeUpperCase($string),
            default => self::returnCamelCase($string)
        };
        
    }


    /**
     * Private inner method : __camelCase__.
     * 
     * Method used to change to camelCase :
     * - Each words are not separated
     * - Each words, except the first one, have first letter uppercase
     *
     * @param string $string
     * 
     * @return string
     * 
     */ 
    private static function returnCamelCase(string $string) : string
    {
        if(!str_contains($string,'_') && !str_contains($string,' ') && !str_contains($string,'-')) return $string;

        $result = self::regexResult($string);

        array_walk($result,fn(&$word) => $word = ucfirst($word));
        $result[0] = strtolower($result[0]);

        return implode('',$result);
    }


    /**
     * Private inner method : __PascalCase__.
     * 
     * Method used to change to PascalCase :
     * - Each words are not separated
     * - Each words have first letter uppercase
     *
     * @param string $string
     * 
     * @return string
     * 
     */ 
    private static function returnPascalCase(string $string) : string
    {
        if(!str_contains($string,'_') && !str_contains($string,' ') && !str_contains($string,'-')) return $string;

        $result = self::regexResult($string);

        array_walk($result,fn(&$word) => $word = ucfirst($word));

        return implode('',$result);
    }


    /**
     * Private inner method : __snake_case__.
     * 
     * Method used to change to snake_case :
     * - Each words are separated with underscore
     * - Each words are lowercases
     *
     * @param string $string
     * 
     * @return string
     * 
     */ 
    private static function returnSnakeCase(string $string) : string
    {
        if(str_contains($string,'_') && !str_contains($string,' ') && !str_contains($string,'-')) return strtolower($string);

        $result = self::regexResult($string);

        return implode('_',$result);
    }


    /**
     * Private inner method : __SNAKE_CASE_UPPERCASE__.
     * 
     * Method used to change to SNAKE_CASE_UPPERCASE :
     * - Each words are separated with underscore
     * - Each words are uppercase
     *
     * @param string $string
     * 
     * @return string
     * 
     */ 
    private static function returnSnakeUpperCase(string $string) : string
    {
        if(str_contains($string,'_') && !str_contains($string,' ') && !str_contains($string,'-')) return strtoupper($string);

        $result = self::regexResult($string);

        array_walk($result,fn(&$word) => $word = strtoupper($word));

        return implode('_',$result);
    }


    /**
     * Private inner method : __regexResult__.
     * 
     * Method used to perform regex
     *
     * @param string $string
     * 
     * @return array
     * 
     */ 
    private static function regexResult(string $string) : array
    {
        preg_match_all(self::$matchingRegex,$string,$array);
        return $array[0];
    }
}
?>