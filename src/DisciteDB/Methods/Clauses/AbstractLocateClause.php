<?php

namespace DisciteDB\Methods\Clauses;

use DisciteDB\Config\Enums\QueryLocation;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataValue;
use mysqli;

abstract class AbstractLocateClause
{
    protected string $key;

    protected mixed $value;

    protected array $parts;

    protected mysqli $connection;

    protected QueryLocation $queryLocation;
    
    protected string $templateUnique = '{KEY} = {VALUE}';
    
    protected string $templateSeparator = ' ';
    
    protected string $templateForm = '{UNIQUE}';

    public function __construct(string $key, mixed $value, QueryLocation $queryLocation, mysqli $connection)
    {
        $this->key = $key;
        $this->value = $value;
        $this->queryLocation = $queryLocation;
        $this->connection = $connection;
    }

    public function toSql(): string
    {
        $this->key = $this->escapeKey();
        $this->value = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    public function toCondition(): string
    {
        $this->key = $this->escapeKey();
        $this->value = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    public function toValue(): string
    {
        $this->key = '';
        $this->templateUnique = '{VALUE}';
        $this->value = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    protected function escapeKey() : string
    {
        return DataKey::escape($this->key,$this->connection);
    }

    protected function escapeValue() : string|array
    {
        if(is_array($this->value))
        {
            $_array = [];

            foreach($this->value as $value)
            {
                $_array[] = DataValue::escape($this->formatLocation($value),$this->connection);
            }

            return $_array;
        }

        return DataValue::escape($this->formatLocation($this->value),$this->connection);
    }

    protected function formatStructure() : array
    {
        if(is_array($this->value))
        {
            $_array = [];

            foreach($this->value as $value)
            {
                $_array[] = $this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$value]);
            }

            return $_array;
        }
        return [$this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$this->value])];
    }

    protected function formatForm() : string
    {
        return $this->searchReplace($this->templateForm,['KEY'=>$this->key,'UNIQUE'=>implode($this->templateSeparator,$this->parts)]);
    }

    protected function formatLocation(string $value) : string
    {
        switch($this->queryLocation)
        {
            case QueryLocation::StartWith :
                return addslashes($value)."%";
                break;
            case QueryLocation::EndWith :
                return "%".addslashes($value);
                break;
            case QueryLocation::Between :
                return "%".addslashes($value)."%";
                break;
            default :
                return "%".addslashes($value)."%";
                break;
        }
    }

    protected function searchReplace(string $haystack, array|string $needle) : string
    {
        foreach($needle as $search => $replace)
        {
            $haystack = str_replace('{'.$search.'}',$replace,$haystack);
        }
        return $haystack;
    }
}

?>