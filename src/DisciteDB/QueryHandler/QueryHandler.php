<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Core\QueryManager;
use DisciteDB\QueryHandler\Handler\HandlerArgument;
use DisciteDB\QueryHandler\Handler\HandlerMethods;
use DisciteDB\QueryHandler\Handler\HandlerModifier;
use DisciteDB\QueryHandler\Handler\HandlerStructure;
use DisciteDB\QueryHandler\Handler\HandlerTemplate;
use DisciteDB\QueryHandler\Handler\HandlerUuid;

class QueryHandler
{
    protected QueryManager $queryManager;

    protected HandlerTemplate $handlerTemplate;

    protected HandlerStructure $handlerStructure;

    protected HandlerArgument $handlerArguments;

    protected HandlerModifier $handlerModifier;

    protected HandlerMethods $handlerMethod;

    protected ?HandlerUuid $handlerUuid;

    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->handleTemplate();
        $this->handleMethods();
        $this->handleStructure();
        $this->handleArguments();
        $this->handleModifier();
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

    public function returnModifier() : array
    {
        return $this->handlerModifier->retrieve();
    }

    public function returnMethods() : array
    {
        return $this->handlerMethod->retrieve();
    }

    private function handleUuid() : void
    {
        if($this->queryManager->getUuid() === null) return;
        $this->handlerUuid = new HandlerUuid($this->queryManager->getUuid(),$this->queryManager->getConnection());
    }

    private function handleArguments() : void
    {
        $this->handlerArguments = new HandlerArgument($this->queryManager->getArgs(),$this->queryManager->getOperator(),$this->queryManager->getConnection());
    }
    private function handleMethods() : void
    {
        $this->handlerMethod = new HandlerMethods($this->queryManager->getTable(),$this->queryManager->getInstance(), $this->queryManager->getConnection());
    }
    private function handleModifier() : void
    {
        $this->handlerModifier = new HandlerModifier($this->queryManager->getArgs(), $this->queryManager->getConnection());
    }
    private function handleStructure() : void
    {
        $this->handlerStructure = new HandlerStructure($this->queryManager->getTable(),$this->queryManager->getOperator(), $this->queryManager->getConnection(), $this->handlerMethod->retrieveForeign());
    }
    private function handleTemplate() : void
    {
        $this->handlerTemplate = new HandlerTemplate($this->queryManager->getOperator(),$this->queryManager->getInstance());
    }


    

}

?>