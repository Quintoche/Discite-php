<?php
namespace DisciteDB\Core;

use DisciteDB\Configuration;

class UsersManager
{
    private Configuration $configuration;
    
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }
}

?>