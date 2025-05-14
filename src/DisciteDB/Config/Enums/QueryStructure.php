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
enum QueryStructure : int 
{
    /*
     * __Select__
     * 
     * Select query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Select = 610;


    /** 
     * __SelectSpecific__
     * 
     * Select Specific operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case SelectSpecific = 611;


    /** 
     * __SelectAll__
     * 
     * Select All operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case SelectAll = 612;

    /** 
     * __Update__
     * 
     * Update query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Update = 613;

    /** 
     * __Insert__
     * 
     * Insert query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Insert = 614;


    /** 
     * __Delete__
     * 
     * Delete query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Delete = 615;

    /** 
     * __CreateTable__
     * 
     * Create Table query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case CreateTable = 616;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case CreateKey = 617;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case DeleteKey = 618;

    /** 
     * __CreateKey__
     * 
     * Create Key query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case UpdateKey = 619;

    /** 
     * __Join__
     * 
     * Join query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Join = 6110;



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