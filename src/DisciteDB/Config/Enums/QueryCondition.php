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
enum QueryCondition : int 
{
    /*
     * __Equal__
     * 
     * Equal.
    */
    case Equal = 900;

    /** 
     * __Or__
     * 
     * Or.
    */
    case Or = 901;

    /** 
     * __Contains__
     * 
     * Contains.
    */
    case Contains = 902;

    /** 
     * __between__
     * 
     * between.
    */
    case Between = 903;

    /** 
     * __Not__
     * 
     * Not.
    */
    case Not = 904;

    /** 
     * __NotIn__
     * 
     * NotIn.
    */
    case NotIn = 905;

    /** 
     * __NotContains__
     * 
     * NotContains.
    */
    case NotContains = 906;

    /** 
     * __Like__
     * 
     * Like.
    */
    case Like = 907;

    /** 
     * __NotLike__
     * 
     * NotLike.
    */
    case NotLike = 908;

    /** 
     * __NotBetween__
     * 
     * NotBetween.
    */
    case NotBetween = 909;

    /** 
     * __MoreThan__
     * 
     * MoreThan.
    */
    case MoreThan = 9010;

    /** 
     * __LessThan__
     * 
     * LessThan.
    */
    case LessThan = 9011;

    /** 
     * __MoreOrEqual__
     * 
     * MoreOrEqual.
    */
    case MoreOrEqual = 9012;

    /** 
     * __LessorEqual__
     * 
     * LessorEqual.
    */
    case LessOrEqual = 9013;
    
}
?>