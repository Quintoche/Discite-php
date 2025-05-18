<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query result type.
 *
 * This enum help to define query result type. 
 * You can choose between theses expressions :
 * 
 * - Data : Data type.
 * - Exception : Exception type.
 * - Async : Async type.
 * 
 * @enum
 */
enum QueryType : int 
{
    /*
     * __Data__
     * 
     * Data.
    */
    case Data = 800;

    /** 
     * __Exception__
     * 
     * Exception.
    */
    case Exception = 801;

    /** 
     * __Async__
     * 
     * Async.
    */
    case Async = 802;
}
?>