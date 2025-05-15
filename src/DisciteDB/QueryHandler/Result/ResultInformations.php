<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Core\QueryManager;

class ResultInformations
{
    public static function handleTimeArray() : int
    {
        return self::handleCurrentTime();
    }
    private static function handleCurrentTime() : int
    {
        return time();
    }

    public static function handleQueryArray(QueryManager $queryManager, ResultData $queryResult) : array
    {
        return [
            'operator' => self::handleQueryOperator($queryManager),
            'table' => self::handleQueryTable($queryManager),
            'gaveArgments' => self::handleQueryArgs($queryManager),
            'affectedRows' => self::handleQueryRows($queryResult),
        ];
    }

    private static function handleQueryOperator(QueryManager $queryManager) : string
    {
        return $queryManager->getOperator()->name;
    }

    private static function handleQueryTable(QueryManager $queryManager) : string
    {
        return $queryManager->getTable()->getAlias() ?? $queryManager->getTable()->getName();
    }

    private static function handleQueryArgs(QueryManager $queryManager) : int
    {
        return sizeof($queryManager->getArgs());
    }

    private static function handleQueryRows(ResultData $queryResult) : ?int
    {
        return $queryResult->getResulRows();
    }

    public static function handleQueryStatus(ResultData $queryResult) : string
    {
        return (!$queryResult->hasError()) ? 'success' : 'error';
    }

    public static function handleQueryErrors(ResultData $queryResult) : ?array
    {
        if(!$queryResult->hasError())
        {
            return null;    
        }

        return $queryResult->getResultError();
    }
    
}

?>