<?php

namespace DisciteDB\Exceptions;

use Exception;

class ConnectionException extends Exception
{
    protected string $dsn;
    protected array $config;

    public function __construct(string $message, int $code = 0, string $dsn = '', array $config = [])
    {
        parent::__construct($message, $code);

        $this->dsn = $dsn;
        $this->config = $config;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function errorMessage(): string
    {
        return sprintf(
            "Connection Error: %s\nDSN: %s\nConfig: %s",
            $this->getMessage(),
            $this->getDsn(),
            json_encode($this->getConfig())
        );
    }
}

?>