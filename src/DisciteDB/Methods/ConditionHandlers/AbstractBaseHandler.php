<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataValue;
use mysqli;

abstract class AbstractBaseHandler
{
    protected string $key;

    protected mixed $value;

    protected array $parts;

    protected mysqli $connection;

    protected QueryCondition $modifier;
    
    protected string $templateUnique = '{TABLE}.{KEY} = {VALUE}';
    
    protected string $templateSeparator = ' ';
    
    protected string $templateForm = '{UNIQUE}';

    public function __construct(string $key, mixed $value, mysqli $connection)
    {
        $this->key = $key;
        $this->value = $value;
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

    public function toDatas() : array
    {
        return [
            'key' => $this->getKey(),
            'value' => $this->getValue(),
            'modifier' => $this->getModifier(),
        ];
    }

    protected function getKey() : string
    {
        return $this->key;
    }

    protected function getValue() : mixed
    {
        return $this->value;
    }

    protected function getModifier() : QueryCondition
    {
        return $this->modifier;
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
                if($value instanceof QueryConditionExpression)
                {
                    $_array[] = $value;
                }
                else
                {
                    $_array[] = DataValue::escape($value,$this->connection);
                }
            }

            return $_array;
        }

        return DataValue::escape($this->value,$this->connection);
    }

    protected function formatStructure() : array
    {
        if(is_array($this->value))
        {
            $_array = [];

            foreach($this->value as $value)
            {
                if($value instanceof QueryConditionExpression)
                {
                    $_array[] = $value->returnCondition($this->key,$this->connection);
                    continue;
                }

                if($value == 'NULL')
                {
                    $_array[] = $this->searchReplace('{TABLE}.{KEY} IS {VALUE}',['KEY'=>$this->key,'VALUE'=>$value]);
                }
                else
                {
                    $_array[] = $this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$value]);
                }
            }

            return $_array;
        }
        
        return [$this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$this->value])];
    }

    protected function formatForm() : string
    {
        return $this->searchReplace($this->templateForm,['KEY'=>$this->key,'UNIQUE'=>implode($this->templateSeparator,$this->parts)]);
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