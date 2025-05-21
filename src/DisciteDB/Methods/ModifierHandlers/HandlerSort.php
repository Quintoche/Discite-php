<?php

namespace DisciteDB\Methods\ModifierHandlers;

use DisciteDB\Config\Enums\QueryModifier;
use DisciteDB\Config\Enums\QuerySort;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Sql\Data\DataKey;
use mysqli;

class HandlerSort implements ArgumentHandlerInterface
{
    protected string $key;
    
    protected mixed $args;

    protected array $parts;

    protected mysqli $connection;

    protected string $templateUnique  = '{TABLE}.{KEY} {VALUE}';
    protected string $templateSeparator = ', ';
    protected string $templateStructure    = 'ORDER BY {UNIQUE}';
    
    protected QueryModifier $modifier = QueryModifier::Sort;

    public function __construct(?array $args, mysqli $connection) 
    {
        $this->connection = $connection;
        $this->parts = [];
        $this->parts = $this->buildParts($args);
        
    }

    public function toSql(): string
    {
        return $this->formateStructure();
    }

    private function buildParts(?array $args) : array
    {
        $_array = [];
        foreach($args as $k => $parts)
        {
            [$method, $key] = $parts;

            $escapedMethod = self::retrieveMethodName($method);
            $escapedKey = $this->escapeKey(self::retrieveKeyName($key));

            $_array[] = $this->formatUnique($escapedKey,$escapedMethod);
        }

        return $_array;
    }

    private function escapeKey(string $key) : string
    {
        return DataKey::escape($key, $this->connection);
    }

    private static function retrieveKeyName(mixed $key) : string
    {
        return match (true) {
            $key instanceof BaseKey => $key->getName(),
            is_string($key) => $key,
            default => null,
        };
    }

    private static function retrieveMethodName(QuerySort $sortMethod)  : string
    {
        return match ($sortMethod) {
            QuerySort::Asc  => 'ASC',
            QuerySort::Desc => 'DESC',
            default         => '',
        };
    }

    private function formatUnique(string $escapedKey, string $escapedMethod) : string
    {
        return self::searchReplace($this->templateUnique, ['KEY'=>$escapedKey, 'VALUE'=>$escapedMethod]);
    }

    private function formatForm(array $escapedArray) : string
    {
        return implode($this->templateSeparator,$escapedArray);
    }

    private function formateStructure() : string
    {
        return self::searchReplace($this->templateStructure, ['UNIQUE'=>$this->formatForm($this->parts)]);
    }

    private static function searchReplace(string $haystack, array|string $needle) : string
    {
        foreach($needle as $search => $replace)
        {
            $haystack = str_replace('{'.$search.'}',$replace,$haystack);
        }
        return $haystack;
    }
}
