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
    case Base = 610;


    /** 
     * __SelectSpecific__
     * 
     * Select Specific operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Structure = 611;


    /** 
     * __SelectAll__
     * 
     * Select All operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Methods = 612;

    /** 
     * __Update__
     * 
     * Update query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Datas = 613;

    /** 
     * __Insert__
     * 
     * Insert query structure used in back code for QueryBuilder.
     * Don't not try to update or modify theses values.
    */
    case Conditions = 614;
}
?>