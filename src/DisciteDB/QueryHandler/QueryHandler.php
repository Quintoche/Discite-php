<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Core\QueryManager;
use DisciteDB\QueryHandler\Handler\HandlerArgument;
use DisciteDB\QueryHandler\Handler\HandlerStructure;
use DisciteDB\QueryHandler\Handler\HandlerTemplate;
use DisciteDB\QueryHandler\Handler\HandlerUuid;

class QueryHandler
{
    protected QueryManager $queryManager;

    protected HandlerTemplate $handlerTemplate;

    protected HandlerStructure $handlerStructure;

    protected HandlerArgument $handlerArguments;

    protected ?HandlerUuid $handlerUuid;

    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->handleTemplate();
        $this->handleStructure();
        $this->handleArguments();
        $this->handleUuid();
    }

    public function returnTemplate() : array
    {
        return $this->handlerTemplate->retrieve();
    }

    public function returnStructure() : array
    {
        return $this->handlerStructure->retrieve();
    }

    public function returnArguments() : array
    {
        return $this->handlerArguments->retrieve();
    }

    public function returnUuid() : array
    {
        return $this->handlerUuid->retrieve();
    }

    private function handleUuid()
    {
        if($this->queryManager->getUuid() === null) return;
        $this->handlerUuid = new HandlerUuid($this->queryManager->getUuid(),$this->queryManager->getConnection());
    }

    private function handleArguments()
    {
        $this->handlerArguments = new HandlerArgument($this->queryManager->getArgs(),$this->queryManager->getOperator(),$this->queryManager->getConnection());
    }
    private function handleMethods()
    {

    }
    private function handleStructure() : void
    {
        $this->handlerStructure = new HandlerStructure($this->queryManager->getTable(),$this->queryManager->getOperator());
    }
    private function handleTemplate() : void
    {
        $this->handlerTemplate = new HandlerTemplate($this->queryManager->getOperator());
    }


    

}

?>