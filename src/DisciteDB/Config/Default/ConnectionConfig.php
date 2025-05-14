<?php

namespace DisciteDB\Config\Default;

class ConnectionConfig
{

    public const DEFAULT_HOSTNAME = 'localhost';
    
    public const DEFAULT_USERNAME = 'root';
    
    public const DEFAULT_PASSWORD = '';
    
    public const DEFAULT_DATABASE = 'db';
    
    public const DEFAULT_PORT = null;

    public static ?string $DATABASE = null;
    
}

?>