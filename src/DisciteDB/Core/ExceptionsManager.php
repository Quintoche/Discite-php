<?php

namespace DisciteDB\Core;

class ExceptionsManager
{
    
    protected string $errorText = '';
    
    protected int $errorCode = 0;

    protected string $errorContext = 'unknown';
    
    public function __construct(string $message, int $code = 0, string $context = 'global')
    {
        $this->errorText = $message;
        
        $this->errorCode = $code;

        $this->errorContext = $context;
    }

    public function getContext(): string
    {
        return $this->errorContext;
    }

    public function getText(): string
    {
        return $this->errorText;
    }

    public function getCode(): int
    {
        return $this->errorCode;
    }

}

?>