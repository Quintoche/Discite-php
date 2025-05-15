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
     * Between operator used in to change query to look for a value which is in middle of searched value.
    */
    case Between = 602;
}
?>