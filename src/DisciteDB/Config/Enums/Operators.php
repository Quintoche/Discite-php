<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable operators.
 *
 * This enum is used to help me to select operators. Do not attempt to update them.
 * 
 * - All : All operator.
 * - Compare : Compare operator.
 * - Count : Count operator.
 * - Create : Create operator.
 * - Delete : Delete operator.
 * - Keys : Keys operator.
 * - Listing : Listing operator.
 * - Retrieve : Retrieve operator.
 * - Update : Update operator.
 * 
 * @enum
 */
enum Operators : int 
{
    /*
     * __All__
     * 
     * All operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case All = 580;

    /** 
     * __Compare__
     * 
     * Compare operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Compare = 581;

    /** 
     * __Count__
     * 
     * Count operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Count = 582;

    /** 
     * __Create__
     * 
     * Create operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Create = 583;

    /** 
     * __Delete__
     * 
     * Delete operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Delete = 584;

    /** 
     * __Keys__
     * 
     * Keys operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Keys = 585;

    /** 
     * __Listing__
     * 
     * Listing operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Listing = 586;

    /** 
     * __Retrieve__
     * 
     * Retrieve operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Retrieve = 587;

    /** 
     * __Update__
     * 
     * Update operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Update = 588;

    /** 
     * __Sum__
     * 
     * Sum operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Sum = 589;

    /** 
     * __Average__
     * 
     * Average operator used in back code to retrieve operators.
     * Don't not try to update or modify theses values.
    */
    case Average = 5810;



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