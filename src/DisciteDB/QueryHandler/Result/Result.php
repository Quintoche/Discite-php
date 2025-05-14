<?php

namespace DisciteDB\QueryHandler\Result;

use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\Operators;
use mysqli;
use mysqli_result;

class Result
{
    protected string $query;

    protected mysqli_result|bool $rawResult;

    protected mixed $result;

    protected mysqli $connection;

    protected Operators $operator;

    protected ?string $resultText = '';

    protected ?int $resultCode = 00;
    
    public function __construct(string $query, mysqli $connection, Operators $operator)
    {
        $this->query = $query;
        $this->connection = $connection;
        $this->operator = $operator;

        $this->rawResult = $this->performQuery();

        $this->getFollow();

    }

    public function __destruct()
    {
        if(!$this->rawResult instanceof mysqli_result) return;
        @mysqli_free_result($this->rawResult);
    }

    private function getFollow()
    {
        match(true)
        {
            $this->rawResult instanceof mysqli_result => $this->performData(),
            $this->rawResult === true => $this->performLast(),
            $this->rawResult === false => $this->performError(),
        };
    }

    private function performQuery() : mixed
    {
        try {
            return @mysqli_query($this->connection,$this->query);
        } catch (\Exception $e) {
            return false;
        }

    }

    private function performData()
    {
        $this->result = match($this->operator)
        {
            Operators::Retrieve => mysqli_fetch_assoc($this->rawResult) ?? [],
            default => mysqli_fetch_all($this->rawResult, MYSQLI_ASSOC),
        };
    }
    private function performLast()
    {
        $this->result = match($this->operator)
        {
            Operators::Create => ['need_previous_data' => mysqli_insert_id($this->connection) ?? 'not_defined'],
            Operators::Delete => [],
            default => ['need_previous_data'=>true],
        };
    }
    private function performError()
    {
        $this->result = [];

        $this->resultText = mysqli_error($this->connection);
        $this->resultCode = mysqli_errno($this->connection);
    }

    public function getResult() : array
    {
        return $this->result;
    }

    public function getResultError() : array
    {
        return ['text'=>$this->resultText,'code'=>$this->resultCode];
    }

}

?>