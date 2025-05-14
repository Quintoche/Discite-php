<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of table usage.
 *
 * This enum is used to choose the way you want to use this librairie:
 * - StrictUsage: Tables have to be defined before used.
 * - LooseUsage: Tables shouldn't be defined before used.
 *
 * @enum
 */
enum TableUsage : int 
{
    /** 
     * __Strict usage__
     * 
     * Tables have to be defined before used.
    */
    case StrictUsage = 101;

    /** 
     * __Loose usage__
     * 
     * Tables shouldn't be defined before used.
     * e.g : $db->undefinedTable->create([]);
    */
    case LooseUsage = 102;



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