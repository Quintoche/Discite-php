<?php
namespace DisciteDB;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Core\KeysManager;
use DisciteDB\Core\LogsManager;
use DisciteDB\Core\SecurityManager;
use DisciteDB\Core\TablesManager;
use DisciteDB\Core\UsersManager;
use mysqli;

class Database
{

    protected Connection $connection;

    protected Configuration $configuration;

    protected KeysManager $keysManager;

    protected TablesManager $tablesManager;

    protected UsersManager $usersManager;

    protected LogsManager $logsManager;

    protected SecurityManager $securityManager;

    public function __construct(?mysqli $connection = null)
    {
        $this->connection = new Connection($connection);

        $this->configuration = new Configuration($this);

        $this->tablesManager = new TablesManager($this);
        
        $this->keysManager = new KeysManager($this);

    }

    public function config() : Configuration
    {
        return $this->configuration;
    }

    public function connection() : Connection
    {
        return $this->connection;
    }


    public function tables() : TablesManager
    {
        return $this->tablesManager;
    }

    public function keys() : KeysManager
    {
        return $this->keysManager;
    }

    public function security() : SecurityManager
    {
        return $this->securityManager;
    }

    public function logs() : LogsManager
    {
        return $this->logsManager;
    }

    public function users() : UsersManager
    {
        return $this->usersManager;
    }


    public function __get(string $name)
    {
        return $this->tables()->getTable($name) ?? throw new \Exception("Table '$name' not defined.");
    }
}

?>