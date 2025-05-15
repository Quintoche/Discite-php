<?php
namespace DisciteDB;

use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Core\KeysManager;
use DisciteDB\Core\LogsManager;
use DisciteDB\Core\SecurityManager;
use DisciteDB\Core\TablesManager;
use DisciteDB\Core\UsersManager;
use DisciteDB\Tables\TableInterface;
use mysqli;

/**
 * Class Database
 * 
 * Central class to manage database connection, configuration, tables, keys, users, logs and security.
 * Provides convenient accessors to all subsystems related to database management.
 * 
 * @package DisciteDB
 */
class Database
{

    /**
     * @var Connection Mysqli connection manager instance.
     */
    protected Connection $connection;


    /**
     * @var Configuration Configuration manager instance.
     */
    protected Configuration $configuration;


    /**
     * @var KeysManager Keys manager instance to handle database keys.
     */
    protected KeysManager $keysManager;


    /**
     * @var TablesManager Tables manager instance to handle table definitions and queries.
     */
    protected TablesManager $tablesManager;


    /**
     * @var UsersManager Users manager instance.
     */
    protected UsersManager $usersManager;


    /**
     * @var LogsManager Logs manager instance.
     */
    protected LogsManager $logsManager;


    /**
     * @var SecurityManager Security manager instance.
     */
    protected SecurityManager $securityManager;


    /**
     * Database constructor.
     * 
     * Initializes connection and all sub-managers.
     * 
     * @param mysqli|null $connection Optional external mysqli connection instance.
     */
    public function __construct(?mysqli $connection = null)
    {
        $this->connection = new Connection($connection);

        $this->configuration = new Configuration($this);

        $this->tablesManager = new TablesManager($this);

        $this->keysManager = new KeysManager($this);

        // Initialize other managers if necessary
        $this->usersManager = new UsersManager($this);
        $this->logsManager = new LogsManager($this);
        $this->securityManager = new SecurityManager($this);
    }


    /**
     * Access the configuration manager.
     * 
     * @return Configuration Configuration manager instance.
     */
    public function conf(): Configuration
    {
        return $this->configuration;
    }

    
    /**
     * Access the configuration manager.
     * 
     * @return Configuration Configuration manager instance.
     */
    public function config(): Configuration
    {
        return $this->configuration;
    }

    
    /**
     * Access the configuration manager.
     * 
     * @return Configuration Configuration manager instance.
     */
    public function configuration(): Configuration
    {
        return $this->configuration;
    }


    /**
     * Access the connection manager.
     * 
     * @return Connection Connection manager instance.
     */
    public function connection(): Connection
    {
        return $this->connection;
    }


    /**
     * Access the tables manager.
     * 
     * @return TablesManager Tables manager instance.
     */
    public function tables(): TablesManager
    {
        return $this->tablesManager;
    }


    /**
     * Access the keys manager.
     * 
     * @return KeysManager Keys manager instance.
     */
    public function keys(): KeysManager
    {
        return $this->keysManager;
    }


    /**
     * Access the security manager.
     * 
     * @return SecurityManager Security manager instance.
     */
    public function security(): SecurityManager
    {
        return $this->securityManager;
    }


    /**
     * Access the logs manager.
     * 
     * @return LogsManager Logs manager instance.
     */
    public function logs(): LogsManager
    {
        return $this->logsManager;
    }


    /**
     * Access the users manager.
     * 
     * @return UsersManager Users manager instance.
     */
    public function users(): UsersManager
    {
        return $this->usersManager;
    }


    /**
     * Retrieve a table interface by its name.
     * 
     * Shortcut to getTable() method.
     * 
     * @param string $name Table name.
     * 
     * @return TableInterface Returns the table interface instance.
     * 
     * @throws \Exception Throws exception if table is not defined.
     */
    public function table(string $name): TableInterface
    {
        return $this->getTable($name);
    }


    /**
     * Magic getter to retrieve a table interface by property access.
     * 
     * Allows syntax like $database->tableName.
     * 
     * @param string $name Table name.
     * 
     * @return TableInterface Table interface instance.
     * 
     * @throws \Exception Throws exception if table is not defined.
     */
    public function __get(string $name): TableInterface
    {
        return $this->getTable($name);
    }


    /**
     * Internal method to retrieve a table by name, considering table usage configuration.
     * 
     * @param string $name Table name.
     * 
     * @return TableInterface Table interface instance.
     * 
     * @throws \Exception Throws exception if table is not defined.
     */
    private function getTable(string $name): TableInterface
    {
        $table = ($this->config()->getTableUsage() === TableUsage::LooseUsage)
            ? $this->tables()->create($name, ['alias' => $name])->getName()
            : $name;

        return $this->tables()->getTable($table) ?? throw new \Exception("Table '$name' not defined.");
    }
}

?>
