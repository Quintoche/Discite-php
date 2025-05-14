<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\QueryHandler\Result\Result;
use mysqli;

class QueryResult
{
    protected QueryBuilder $queryBuilder;

    protected mysqli $connection;

    protected Operators $operator;

    protected Result $result;

    protected ?string $table;

    protected array $uuid;
    
    public function __construct(QueryBuilder $queryBuilder, mysqli $connection, Operators $operator)
    {
        $this->queryBuilder = $queryBuilder;
        $this->connection = $connection;
        $this->operator = $operator;
        $this->uuid = $this->queryBuilder->getUuid() ?? null;
        $this->table = $this->queryBuilder->getTable() ?? null;

        $this->performResult();

    }

    public function createResult() : array
    {
        return [
            'data'=>$this->handleData(),
            'info'=>$this->handleInformations(),
        ];
    }

    private function handleData() : array
    {
        return (!isset($this->result->getResult()['need_previous_data'])) ? $this->result->getResult() : $this->performNew() ;
    }
    private function handleInformations() : array
    {
        return match(true)
        {
            $this->result->getResultError()['text'] != null && $this->result->getResultError()['code'] != null => ['status'=>'error','error'=>['text'=>$this->result->getResultError()['text'],'code'=>$this->result->getResultError()['code']],'time'=>time()],
            isset($this->result->getResult()['need_previous_data']) => ['status'=>'success','operator'=>$this->operator->name,'table'=>$this->table,'time'=>time()],
            default => ['status'=>'success','operator'=>$this->operator->name,'table'=>$this->table,'rows'=>sizeof($this->result->getResult()),'time'=>time()],
        };
    }

    private function performResult()
    {
        return $this->result = new Result($this->queryBuilder->createBuild(),$this->connection, $this->operator);
    }
    private function performNew()
    {
        $_uuid = [];
        switch($this->result->getResult()['need_previous_data'])
        {
            case true :
                $_uuid = $this->uuid;
                break;
            default :
                $_uuid = ['id'=>$this->result->getResult()['need_previous_data']];
                break;
        }

        return (new Result("SELECT * FROM `{$this->table}` WHERE `".array_keys($_uuid)[0]."` = '".$_uuid[0]."'",$this->connection, Operators::Retrieve))->getResult();
    }
}

?>