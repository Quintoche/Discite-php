<?php
namespace DisciteDB;

use DisciteDB\Core\KeysManager;
use DisciteDB\Core\LogsManager;
use DisciteDB\Core\SecurityManager;
use DisciteDB\Core\TablesManager;
use DisciteDB\Core\UsersManager;

class Configuration
{

    private Database $database;

    public KeysManager $keys;

    public SecurityManager $security;

    public TablesManager $tables;

    public UsersManager $users;

    public LogsManager $logs;


    public function __construct(Database $database)
    {
        $this->database = $database;
        
        $this->keys = new KeysManager($this);

        $this->security = new SecurityManager($this);

        $this->tables = new TablesManager($this);

        $this->users = new UsersManager($this);

        $this->logs = new LogsManager($this);
    }
}

?>