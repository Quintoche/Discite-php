<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query condition.
 *
 * This enum help to define query condition. 
 * You can choose between theses expressions :
 * 
 * 
 * @enum
 */
enum QueryModifier : int 
{
    /*
     * __Order__
     * 
     * Order.
    */
    case Order = 910;

    /** 
     * __Sort__
     * 
     * Sort.
    */
    case Sort = 911;

    /** 
     * __Limit__
     * 
     * Limit.
    */
    case Limit = 912;
    
}
?>