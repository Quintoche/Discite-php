<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query template.
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
enum QueryTemplate : int 
{
    /*
     * __Select__
     * 
     * Select query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Select = 630;


    /** 
     * __SelectSpecific__
     * 
     * Select Specific operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case SelectSpecific = 631;


    /** 
     * __SelectAll__
     * 
     * Select All operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case SelectAll = 632;

    /** 
     * __Update__
     * 
     * Update query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Update = 633;

    /** 
     * __Insert__
     * 
     * Insert query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Insert = 634;


    /** 
     * __Delete__
     * 
     * Delete query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Delete = 635;

    /** 
     * __CreateTable__
     * 
     * Create Table query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case CreateTable = 636;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case CreateKey = 637;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case DeleteKey = 638;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case UpdateKey = 639;

    /** 
     * __Join__
     * 
     * Join query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Join = 6310;



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