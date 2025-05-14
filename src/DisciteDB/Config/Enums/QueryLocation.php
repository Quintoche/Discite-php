<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query location.
 *
 * This enum help to select location in queryMethod enum for ::Contains and ::NotContains. 
 * You can choose between theses expressions :
 * 
 * - StartWith : StartWith operator.
 * - EndWith : EndWith operator.
 * - Between : Between operator.
 * - Not : Not operator.
 * 
 * @enum
 */
enum QueryLocation : int 
{
    /*
     * __StartWith__
     * 
     * StartWith operator used in to change query to look for a value starting with.
    */
    case StartWith = 600;

    /** 
     * __EndWith__
     * 
     * EndWith operator used in to change query to look for a value end with.
    */
    case EndWith = 601;

    /** 
     * __Between__
     * 
     * EndWith operator used in to change query to look for a value wich is in middle of searched value.
    */
    case Between = 602;



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