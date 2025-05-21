<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of joining methods.
 *
 * This enum help to define how result will be showed when making join query. 
 * You can choose between theses expressions :
 * - Flat : Every values appears in the same array
 * - Concat : Joined values appears in the name of foreign table as string separate with pre-defined separator
 * - Json : Joined values appears in the name of foreign table as json
 * - MultidimensionalArray : Joined values appears in the name of foreign table as array
 * 
 * @enum
 */
enum JoinMethod : int 
{
    /*
     * __Flat__
     * 
     * Flat.
    */
    case Flat = 1000;

    /** 
     * __Concat__
     * 
     * Concat.
    */
    case Concat = 1001;

    /** 
     * __Json__
     * 
     * Json.
    */
    case Json = 1002;

    /** 
     * __MultidimensionalArray__
     * 
     * MultidimensionalArray.
    */
    case MultidimensionalArray = 1002;
    
}
?>