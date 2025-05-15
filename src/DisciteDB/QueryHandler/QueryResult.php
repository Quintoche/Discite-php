<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Core\QueryManager;
use DisciteDB\QueryHandler\Result\ResultData;
use DisciteDB\QueryHandler\Result\ResultInformations;

class QueryResult
{
    private QueryManager $queryManager;

    private ?ResultData $result = null;


    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;
        $this->result = $this->performResult();

        $this->handleOtherResult();
    }

    private function performResult() : ResultData
    {
        return new ResultData($this->queryManager->getQueryBuilder()->createBuild(),$this->queryManager->getConnection(),$this->queryManager->getOperator());
    }

    private function handleOtherResult()
    {
        match ($this->queryManager->getOperator()) {
            Operators::Create => $this->result->handleNewResult(mysqli_insert_id($this->queryManager->getConnection()) ?? null, $this->queryManager->getTable()),
            Operators::Update => $this->result->handleNewResult($this->queryManager->getUuid(), $this->queryManager->getTable()),
            default => null,
        };
    }







    public function fetch() : array
    {
        return $this->result->getResult() ?? $this->result->getResultAll() ?? [];
    }

    public function fetchAll() : array
    {
        return $this->result->getResult() ?? $this->result->getResultAll() ?? [];
    }

    public function fetchNext()
    {
        return ['data'=>$this->result->getResult() ?? $this->result->getResultNext(), 'info' => $this->fetchInformations()] ?? [];
    }
    
    public function fetchGenerator(): \Generator
    {
        if (!$this->result) {
            return;
        }

        while ($row = $this->result->getResultNext()) {
            yield $row;
        }
    }

    public function fetchArray() : array
    {
        return [
            'data' => $this->result->getResult() ?? $this->result->getResultAll() ?? [],
            'info' => $this->fetchInformations(),
        ];
    }

    public function fetchInformations() : array
    {
        return [
            'status' => ResultInformations::handleQueryStatus($this->result),
            'time' => ResultInformations::handleTimeArray(),
            'query' => ResultInformations::handleQueryArray($this->queryManager, $this->result),
            'error' => ResultInformations::handleQueryErrors($this->result),
        ];
    }

    public function count() : int
    {
        return $this->result->getResulRows() ?? 0;
    }

}

?>