<?php

namespace DisciteDB\QueryHandler;

use DisciteDB\Core\QueryManager;
use DisciteDB\Methods\QueryConditionExpression;

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
        $this->query = $this->searchReplace($this->query,array_merge($this->associateKeys(),$this->associateValues(),$this->associateArgs(),$this->associateModifier()));
        $this->query = $this->searchReplace($this->query,$this->associateUuid());
        $this->query = $this->searchReplace($this->query,['TABLE' => $this->queryHandler->returnStructure()['TABLE']]);

        return $this->query;
    }

    private function associateTemplate() : void
    {
        $_array = [];

        foreach($this->queryHandler->returnTemplate() as $i => $data)
        {
            if(is_null($data)) continue;
            if($i == 'Methods') $this->associateMethods($data);

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
            if(($data instanceof QueryConditionExpression)) continue;
            $_array[] = $data;
        }

        return ['VALUES'=>implode(', ',$_array)];
    }

    private function associateModifier() : array
    {
        if(!$this->queryHandler->returnModifier()['MODIFIER']) return ['MODIFIER'=>''];
        
        $_array = [];
        foreach($this->queryHandler->returnModifier()['MODIFIER'] as $data)
        {
            if(is_null($data)) continue;
            $_array[] = $data;
        }

        return ['MODIFIER'=>implode(' ',$_array)];
    }

    private function associateMethods(string &$template) : void
    {
        if($this->queryHandler->returnMethods()['COUNT'] == 0) {$template = null; return;}

        $_array = [];
        
        for($j=0;$j<(int)$this->queryHandler->returnMethods()['COUNT'];$j++)
        {
            $_template = $template;
            $_table = $this->queryHandler->returnMethods()['TABLE'][$j];
            $_indexKey = $this->queryHandler->returnMethods()['INDEX_KEY'][$j];
            $_tableForeign = $this->queryHandler->returnMethods()['TABLE_FOREIGN'][$j];
            $_foreignPrimaryKey = $this->queryHandler->returnMethods()['FOREIGN_PRIMARY_KEY'][$j];

            
            $_array[] = $this->searchReplace($_template,['TABLE'=>$_table,'INDEX_KEY'=>$_indexKey,'TABLE_FOREIGN'=>$_tableForeign,'FOREIGN_PRIMARY_KEY'=>$_foreignPrimaryKey]);
        }
        $template = implode(' ',$_array);
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