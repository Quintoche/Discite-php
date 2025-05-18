<?php

namespace DisciteDB\QueryHandler\Result;

abstract class AbstractResult
{
    protected ?string $exceptionContext = null;

    protected ?string $exceptionText = null;

    protected ?int $exceptionCode = null;
    
    /**
     * Retourne les éventuelles erreurs rencontrées.
     */
    public function getResultError(): array
    {
        return [
            'text' => $this->exceptionText,
            'code' => $this->exceptionCode,
        ];
    }

    public function getContext() : ?string
    {
        return $this->exceptionContext ?? null;
    }
}

?>