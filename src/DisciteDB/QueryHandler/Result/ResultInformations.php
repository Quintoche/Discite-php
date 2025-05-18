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

    public static function handleQueryArray(QueryManager $queryManager, Result $queryResult) : array
    {
        return [
            'operator' => self::handleQueryOperator($queryManager) ?? null,
            'table' => self::handleQueryTable($queryManager) ?? null,
            'context' => self::handleQueryContext($queryResult) ?? null,
            'gaveArgments' => self::handleQueryArgs($queryManager) ?? null,
            'affectedRows' => self::handleQueryRows($queryResult) ?? null,
        ];
    }

    private static function handleQueryOperator(QueryManager $queryManager) : ?string
    {
        if(!$queryManager->getOperator()) return null;
        return $queryManager->getOperator()->name ?? null;
    }

    private static function handleQueryTable(QueryManager $queryManager) : ?string
    {
        if(!$queryManager->getTable()) return null;
        return $queryManager->getTable()->getAlias() ?? $queryManager->getTable()->getName() ?? null;
    }

    private static function handleQueryContext(Result $queryResult) : ?string
    {
        return $queryResult->getContext() ?? null;
    }

    private static function handleQueryArgs(QueryManager $queryManager) : int
    {
        if(!$queryManager->getArgs()) return 0;
        return sizeof($queryManager->getArgs()) ?? 0;
    }

    private static function handleQueryRows(Result $queryResult) : ?int
    {
        return $queryResult->getResulRows() ?? 0;
    }

    public static function handleQueryStatus(Result $queryResult) : string
    {
        return (!$queryResult->hasError()) ? 'success' : 'error';
    }

    public static function handleQueryErrors(Result $queryResult) : ?array
    {
        if(!$queryResult->hasError())
        {
            return null;    
        }

        return $queryResult->getResultError();
    }
    
}

?>