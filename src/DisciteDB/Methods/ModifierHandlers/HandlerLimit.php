<?php

namespace DisciteDB\Methods\ModifierHandlers;

use DisciteDB\Config\Enums\QueryModifier;
use mysqli;

class HandlerLimit implements ArgumentHandlerInterface
{
    protected int $limit;

    protected ?int $offset;
    
    protected array $args;

    protected array $parts;

    protected mysqli $connection;

    protected string $templateLimit  = 'LIMIT {LIMIT}';
    protected string $templateOffset  = 'OFFSET {OFFSET}';
    protected string $templateUnique  = '{LIMIT} {OFFSET}';
    protected string $templateSeparator = ' ';
    protected string $templateStructure    = '{UNIQUE}';
    
    protected QueryModifier $modifier = QueryModifier::Limit;

    public function __construct(?array $args, mysqli $connection) 
    {
        $this->connection = $connection;
        [$this->limit, $this->offset] = $this->buildParts($args);
        
        $this->args['LIMIT'] = $this->escapeLimit($this->limit);
        $this->args['OFFSET'] = $this->escapeOffset($this->offset);



        $this->parts = [];
        $this->parts[] = $this->formatUnique($this->args['LIMIT'],$this->args['OFFSET']);
    }

    public function toSql(): string
    {
        return $this->formateStructure();
    }

    private function buildParts(?array $args)
    {
        return match (count($args)) {
            1 => [(int) $args[0], null],
            2 => $args,
            default => [(int) $args[0], null],
        };
    }

    private function escapeLimit(int $limit)  : ?string
    {
        return match ($limit) {
            0 => null,
            default => $this->searchReplace($this->templateLimit,['LIMIT'=>$limit]),
        };
    }

    private function escapeOffset(?int $offset = null)  : ?string
    {
        return match ($offset) {
            null => null,
            0 => null,
            default => $this->searchReplace($this->templateOffset,['OFFSET'=>$offset]),
        };
    }

    private function formatUnique(string $escapedLimit, ?string $escapedOffset) : string
    {
        return self::searchReplace($this->templateUnique, ['LIMIT'=>$escapedLimit, 'OFFSET'=>$escapedOffset]);
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
            if($replace == null) $replace = '';
            $haystack = str_replace('{'.$search.'}',$replace,$haystack);
        }
        return $haystack;
    }
}
