<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryType;
use DisciteDB\Core\ExceptionsManager;
use DisciteDB\Core\QueryManager;
use DisciteDB\QueryHandler\Result\Result;
use DisciteDB\QueryHandler\Result\ResultData;
use DisciteDB\QueryHandler\Result\ResultExceptions;
use DisciteDB\QueryHandler\Result\ResultInformations;

class QueryResult
{
    private QueryManager $queryManager;

    private QueryType $queryType;

    private ?Result $result = null;

    private ?ExceptionsManager $exception = null;


    public function __construct(QueryManager $queryManager, ?QueryType $queryType = null)
    {
        $this->queryManager = $queryManager;
        
        $this->queryType = $queryType ?? $this->queryManager->getType();
        
        $this->selectResultType();
    }

    private function selectResultType() : void
    {
        match($this->queryType)
        {
            QueryType::Data => $this->resultData(),
            QueryType::Async => $this->resultAsync(),
            QueryType::Exception => $this->resultException(),
            default => $this->resultData(),
        };
    }

    private function resultData() : void
    {
        $this->result = $this->performResultData();
        $this->handleOtherResultData();
    }

    private function resultAsync() : void
    {
        $this->result = $this->performResultData();
        $this->handleOtherResultData();
    }

    private function resultException() : void
    {
        $this->exception = $this->queryManager->getException();

        $this->result = $this->performResultException();
    }


    private function performResultException() : ResultExceptions
    {
        return new ResultExceptions($this->exception);
    }

    private function performResultData() : ResultData
    {
        return new ResultData($this->queryManager);
    }
    
    private function performResultAsync() : ResultData
    {
        return new ResultData($this->queryManager);
    }

    private function handleOtherResultData()
    {
        match ($this->queryManager->getOperator()) {
            // Operators::Create => $this->result->handleNewResult(mysqli_insert_id($this->queryManager->getConnection()) ?? null, $this->queryManager->getTable()),
            Operators::Update => $this->result->handleNewResult($this->queryManager->getUuid(), $this->queryManager->getTable()),
            default => null,
        };
    }







    public function fetch() : array|string|int
    {
        return $this->result->getResult() ?? $this->result->getResultAll() ?? [];
    }

    public function fetchQuery() : string
    {
        return $this->result->getQuery() ?? '';
    }

    public function fetchAll() : array|string|int
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

    public function rows() : int
    {
        return $this->result->getResulRows() ?? 0;
    }


    // 
    // Functions for 
    // 


    public function all($args) : QueryResult
    {
        return $this;
    }

    public function compare($args) : QueryResult
    {
        return $this;
    }

    public function count($args) : QueryResult
    {
        return $this;
    }

    public function create($args) : QueryResult
    {
        return $this;
    }

    public function delete($args) : QueryResult
    {
        return $this;
    }

    public function keys($args) : QueryResult
    {
        return $this;
    }

    public function listing($args) : QueryResult
    {
        return $this;
    }

    public function retrieve($args) : QueryResult
    {
        return $this;
    }

    public function update($args) : QueryResult
    {
        return $this;
    }

}

?>