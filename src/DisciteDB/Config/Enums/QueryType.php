<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query structure.
 *
 * This enum is used to help me to select query structure. Do not attempt to update them.
 * 
 * - Or : Or operator.
 * - Contains : Contains operator.
 * - Between : Between operator.
 * - Not : Not operator.
 * - NotContains : NotContains operator.
 * - NotBetween : NotBetween operator.
 * 
 * @enum
 */
enum QueryType : int 
{
    /*
     * __Data__
     * 
     * Data query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Base = 620;


    /*
     * __Data__
     * 
     * Data query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Structure = 621;


    /** 
     * __Table__
     * 
     * Table query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Methods = 622;


    /** 
     * __Key__
     * 
     * Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Datas = 623;


    /** 
     * __Key__
     * 
     * Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Conditions = 624;


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