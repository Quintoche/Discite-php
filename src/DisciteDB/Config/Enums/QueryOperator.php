<?php

namespace DisciteDB\Config\Enums;

/**
 * Enumeration of usable query Operator.
 *
 * This enum is used to help me to select query Operator. Do not attempt to update them.
 * 
 * - Or : Or operator.
 * - Contains : Contains operator.
 * - Between : Between operator.
 * - Not : Not operator.
 * - NotContains : NotContains operator.
 * - NotBetween : NotBetween operator.
 * 
 * @enum
 */
enum QueryOperator : int 
{
    /*
     * __Or__
     * 
     * Or operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Or = 590;

    /** 
     * __Contains__
     * 
     * Contains operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Contains = 591;

    /** 
     * __Between__
     * 
     * Between operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Between = 592;

    /** 
     * __Not__
     * 
     * Not operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Not = 593;

    /** 
     * __NotContains__
     * 
     * Not Contains operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case NotContains = 594;

    /** 
     * __NotBetween__
     * 
     * Not Between operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case NotBetween = 595;

    /** 
     * __MoreThan__
     * 
     * MoreThan operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case MoreThan = 596;

    /** 
     * __LessThan__
     * 
     * LessThan operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case LessThan = 597;

    /** 
     * __MoreOrEqual__
     * 
     * MoreOrEqual operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case MoreOrEqual = 598;

    /** 
     * __LessOrEqual__
     * 
     * LessOrEqual operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case LessOrEqual = 599;

    /** 
     * __Equal__
     * 
     * Equal operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Equal = 5910;

    /** 
     * __Like__
     * 
     * Like operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case Like = 5911;

    /** 
     * __NotLike__
     * 
     * NotLike operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case NotLike = 5912;

    /** 
     * __NotIn__
     * 
     * NotIn operator used in back code to retrieve query Operators.
     * Don't not try to update or modify theses values.
    */
    case NotIn = 5913;
}
?>