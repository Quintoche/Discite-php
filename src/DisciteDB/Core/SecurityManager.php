<?php
namespace DisciteDB\Core;

use DisciteDB\Configuration;

class SecurityManager
{

    private Configuration $configuration;
    
    protected bool $enableCsrf = false;

    protected bool $enablePermissions = false;

    protected bool $enableSanitize = false;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    public function enableCsrf(bool $value) : void
    {
        $this->enableCsrf = $value;
    }

    public function enablePermissions(bool $value) : void
    {
        $this->enablePermissions = $value;
    }

    public function enableSanitize(bool $value) : void
    {
        $this->enableSanitize = $value;
    }
}

?>