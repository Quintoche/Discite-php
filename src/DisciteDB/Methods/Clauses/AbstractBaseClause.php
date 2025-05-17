<?php

namespace DisciteDB\Methods\Clauses;

use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Sql\Data\DataKey;
use mysqli;

abstract class AbstractBaseClause
{
    protected string $key;
    
    protected mixed $args;

    protected array $parts;

    protected mysqli $connection;
    
    protected string $templateUnique = '';
    
    protected string $templateSeparator = ' ';
    
    protected string $templateForm = '{UNIQUE}';

    public function __construct(mixed $args, mysqli $connection)
    {
        $this->args = $args;
        $this->connection = $connection;
    }

    public function toSql(): string
    {
        $this->key = $this->escapeKey();
        $this->args = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    public function toCondition(): string
    {
        $this->key = $this->escapeKey();
        $this->args = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    public function toValue(): string
    {
        $this->key = '';
        $this->templateUnique = '{VALUE}';
        $this->args = $this->escapeValue();
        $this->parts = $this->formatStructure();

        return $this->formatForm();
    }

    protected function escapeKey() : string
    {
        return DataKey::escape($this->createKey($this->args),$this->connection);
    }

    protected function createKey(array $args) : ?string 
    {
        foreach($args as $arg)
        {
            $key = match(true)
            {
                $arg instanceof BaseKey => $arg->getName(),
                is_string($arg) => $arg,
                default => null,
            };
            if(!is_null($key)) return $key;
        }

        return null;
    }

    protected function createValue(array $args) : ?QuerySort
    {
        foreach($args as $arg)
        {
            $clause = match(true)
            {
                $arg instanceof QuerySort => $arg,
                default => null,
            };
            if(!is_null($clause)) return $clause;
        }

        return null;
    }

    protected function escapeValue() : string
    {
        $value = $this->createValue($this->args);

        return match($value)
            {
                QuerySort::Asc => 'ASC',
                QuerySort::Desc => 'DESC',
                QuerySort::NoSort => '',
                default => '',
            };
    }

    protected function formatStructure() : array
    {
        if(is_array($this->args))
        {
            $_array = [];

            foreach($this->args as $args)
            {
                $_array[] = $this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$args]);
            }

            return $_array;
        }
        return [$this->searchReplace($this->templateUnique,['KEY'=>$this->key,'VALUE'=>$this->args])];
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