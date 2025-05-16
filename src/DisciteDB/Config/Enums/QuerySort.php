<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query sort.
 *
 * This enum help to define default sorting method for a table or add him as param if you want to sort differently. 
 * You can choose between theses expressions :
 * 
 * - NoSort : Not sorting.
 * - Desc : Sort descendant.
 * - Asc : Sort ascendant.
 * 
 * @enum
 */
enum QuerySort : int 
{
    /*
     * __NoSort__
     * 
     * NoSort.
    */
    case NoSort = 700;

    /** 
     * __Desc__
     * 
     * Desc.
    */
    case Desc = 701;

    /** 
     * __Asc__
     * 
     * Asc.
    */
    case Asc = 702;
}
?>