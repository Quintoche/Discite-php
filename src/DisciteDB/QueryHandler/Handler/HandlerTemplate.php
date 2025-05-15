<?php

namespace DisciteDB\QueryHandler\Handler;

use DisciteDB\Config\Default\QueryStructureConfig;
use DisciteDB\Config\Default\QueryTemplateConfig;
use DisciteDB\Config\Default\QueryTypeConfig;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\QueryStructure;
use DisciteDB\Config\Enums\QueryTemplate;

class HandlerTemplate
{
    protected ?array $templateArray;

    protected ?string $templateBase = null;

    protected ?string $templateStructure = null;

    protected ?string $templateMethods = null;

    protected ?string $templateDatas = null;

    protected ?string $templateConditions = null;

    protected Operators $operator;

    protected QueryTemplate $queryTemplate;


    public function __construct(Operators $operator)
    {
        $this->operator = $operator;

        $this->createTemplate();
        $this->createArray();
    }

    public function retrieve() : array
    {
        return $this->templateArray;
    }

    private function selectTemplate() : QueryTemplate
    {
        return match ($this->operator) {
            Operators::All, Operators::CountAll => QueryTemplate::SelectAll,
            Operators::Compare => QueryTemplate::Select,
            Operators::Count => QueryTemplate::Select,
            Operators::Create => QueryTemplate::Insert,
            Operators::Delete => QueryTemplate::Delete,
            Operators::Keys => QueryTemplate::Select,
            Operators::Listing => QueryTemplate::Select,
            Operators::Retrieve => QueryTemplate::Select,
            Operators::Update => QueryTemplate::Update,
            default => QueryTemplate::Select,
        };
    }    
    private function createTemplate() : void
    {
        $this->queryTemplate = $this->selectTemplate();
        
        foreach($this->retrieveTemplate() as $data)
        {
            $this->{'template'.ucfirst($data->name)} = $this->{'getTemplate'.ucfirst($data->name)}();
        }
    }
    private function createArray() : void
    {
        $this->templateArray['Base'] = $this->templateBase;
        $this->templateArray['Structure'] = $this->templateStructure;
        $this->templateArray['Methods'] = $this->templateMethods;
        $this->templateArray['Datas'] = $this->templateDatas;
        $this->templateArray['Conditions'] = $this->templateConditions;
        
    }

    private function retrieveTemplate() : ?array
    {
        return QueryTemplateConfig::$MAP[$this->queryTemplate->name] ?? QueryTemplateConfig::$MAP['default'];
    }
    private function getTemplateBase() : ?string
    {
        return QueryStructureConfig::$MAP[QueryStructure::Base->name][$this->queryTemplate->name] ?? null;
    }
    private function getTemplateStructure() : ?string
    {
        return QueryStructureConfig::$MAP[QueryStructure::Structure->name][$this->queryTemplate->name] ?? null;
    }
    private function getTemplateDatas() : ?string
    {
        return QueryStructureConfig::$MAP[QueryStructure::Datas->name][$this->queryTemplate->name] ?? null;
    }
    private function getTemplateMethods() : ?string
    {
        return QueryStructureConfig::$MAP[QueryStructure::Methods->name][$this->queryTemplate->name] ?? null;
    }
    private function getTemplateConditions() : ?string
    {
        return QueryStructureConfig::$MAP[QueryStructure::Conditions->name][$this->queryTemplate->name] ?? null;
    }
}

?>