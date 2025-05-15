<?php
namespace DisciteDB\Core;

use DisciteDB\Database;

/**
 * __WIP__
 * 
 * __Work in progress__.
 * 
 */
class UsersManager
{
    protected Database $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}

?>