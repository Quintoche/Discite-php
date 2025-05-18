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
    private Database $database;

    protected array $map = [];

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function create($user)
    {
        
    }
}

?>