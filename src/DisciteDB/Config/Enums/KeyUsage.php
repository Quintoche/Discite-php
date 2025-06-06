<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of Key usage.
 *
 * This enum is used to choose the way you want to use this librairie:
 * - StrictUsage: Keys have to be defined before used.
 * - LooseUsage: Keys shouldn't be defined before used.
 *
 * @enum
 */
enum KeyUsage : int 
{
    /** 
     * __Strict usage__
     * 
     * Keys have to be defined before used.
    */
    case StrictUsage = 201;

    /** 
     * __Loose usage__
     * 
     * Keys shouldn't be defined before used.
     * e.g : $db->table->create(['undefinedKey'=>$value]);
    */
    case LooseUsage = 202;
}
?>