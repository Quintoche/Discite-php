<?php

namespace DisciteDB\Exceptions;

use DisciteDB\QueryHandler\Result\ResultInformations;
use Exception;

abstract class AbstractDisciteException extends Exception
{
    protected string $context = 'unknown';

    protected string $status = 'error';

    protected ?array $query  = null;

    protected int $time = 0;

    protected string $errorText = '';

    protected int $errorCode = 0;

    public function __construct(string $message, int $code = 0, string $context = 'global', ?\Throwable $previous = null)
    {
        $this->context = $context;

        $this->errorText = $message;

        $this->errorCode = $code;

        $this->time = ResultInformations::handleTimeArray();

        parent::__construct($message, $code, $previous);
    }

    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Export exception as a ResultInformation object
     */
    public function toResult(): array
    {
        return [
            'data' => [
                'error',
            ],
            'info' => [
            'status' => $this->status,
            'time' => $this->time,
            'query' => $this->query,

            'error' => [
                'text' => $this->errorText,
                'code' => $this->errorCode,
            ],
        ]];
    }
}


?>