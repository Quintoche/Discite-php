<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Database;
use DisciteDB\Tables\BaseTable;
use mysqli;
use mysqli_result;

class ResultAsync extends AbstractResult implements Result
{
    protected string $query;

    protected mysqli_result|bool $rawResult;

    protected mixed $result;

    protected mixed $resultData = null;

    protected mixed $resultRows;

    protected mysqli $connection;

    protected Operators $operator;

    protected Database $database;
    
    public function __construct(string $query, mysqli $connection, Operators $operator, Database $database)
    {
        $this->query = $query;
        $this->connection = $connection;
        $this->operator = $operator;
        $this->database = $database;

    }

    private function checkToken()
    {
        
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