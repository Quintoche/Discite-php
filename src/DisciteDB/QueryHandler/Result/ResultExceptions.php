<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Core\ExceptionsManager;
use DisciteDB\Tables\BaseTable;

class ResultExceptions extends AbstractResult implements Result
{
    protected ExceptionsManager $exception;

    public function __construct(ExceptionsManager $exception)
    {
        $this->exception = $exception;

        $this->createException();
    }
    
    private function createException()
    {
        $this->exceptionContext = $this->exception->getContext();
    
        $this->exceptionText = $this->exception->getText();
        
        $this->exceptionCode = $this->exception->getCode();
    }

    public function getResult() : mixed
    {
        return null;
    }
    public function getResultNext() : mixed
    {
        return null;
    }
    public function getResultAll() : mixed
    {
        return null;
    }
    public function getResulRows() : mixed
    {
        return null;
    }
    public function getQuery() : ?string
    {
        return null;
    }
    public function hasError() : bool
    {
        return true;
    }

    public function handleNewResult(mixed $uuid, BaseTable $table) : void
    {

    }
}

?>