<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryExpression;

class QueryBuilder
{
    protected QueryManager $queryManager;

    protected QueryHandler $queryHandler;

    protected string $query;

    protected ?array $_template;

    protected ?array $_structure;

    protected ?array $_arguments;

    protected ?array $_uuid;

    public function __construct(QueryManager $queryManager)
    {
        $this->queryManager = $queryManager;

        $this->queryHandler = $this->queryManager->getQueryHandler();

        $this->associateTemplate();

    }

    public function createBuild() : string
    {
        $this->query = $this->searchReplace($this->query,$this->queryHandler->returnStructure());
        $this->query = $this->searchReplace($this->query,array_merge($this->associateKeys(),$this->associateValues(),$this->associateArgs()));
        $this->query = $this->searchReplace($this->query,$this->associateUuid());

        return $this->query;
    }

    private function associateTemplate() : void
    {
        $_array = [];
        foreach($this->queryHandler->returnTemplate() as $data)
        {
            if(is_null($data)) continue;

            $_array[] = $data;
        }

        $this->query = implode(' ',$_array);
    }

    private function associateArgs() : array
    {
        if(!$this->queryHandler->returnArguments()['CONDITIONS']) return ['CONDITIONS'=>''];
        
        $_array = [];
        foreach($this->queryHandler->returnArguments()['CONDITIONS'] as $data)
        {
            if(is_null($data)) continue;
            $_array[] = $data;
        }

        return ['CONDITIONS'=>implode($this->queryHandler->returnArguments()['SEPARATOR'],$_array)];
    }

    private function associateUuid() : array
    {
        if(!$this->queryHandler->returnUuid()['UUID']) return ['UUID'=>''];
        
        $_array = [];
        foreach($this->queryHandler->returnUuid()['UUID'] as $data)
        {
            if(is_null($data)) continue;
            $_array[] = $data;
        }

        return ['UUID'=>implode(' ',$_array)];
    }

    private function associateKeys() : array
    {
        if(!$this->queryHandler->returnArguments()['KEYS']) return ['KEYS'=>''];
        
        $_array = [];
        foreach($this->queryHandler->returnArguments()['KEYS'] as $data)
        {
            if(is_null($data)) continue;
            $_array[] = $data;
        }

        return ['KEYS'=>implode(', ',$_array)];
    }

    private function associateValues() : array
    {
        if(!$this->queryHandler->returnArguments()['VALUES']) return ['VALUES'=>''];
        
        $_array = [];
        foreach($this->queryHandler->returnArguments()['VALUES'] as $data)
        {
            if(is_null($data)) continue;
            if(($data instanceof QueryExpression)) continue;
            $_array[] = $data;
        }

        return ['VALUES'=>implode(', ',$_array)];
    }

    private function searchReplace(string $haystack, array|string $needle) : string
    {
        if(is_array($needle))
        {
            foreach($needle as $search => $replace)
            {
                $haystack = str_replace('{'.$search.'}',$replace,$haystack);
            }
            return $haystack;
        }
        else
        {
            return $haystack;
        }
    }
}

?>