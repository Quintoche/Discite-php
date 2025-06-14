<?php
namespace DisciteDB;

use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Core\DebugManager;
use DisciteDB\Core\KeysManager;
use DisciteDB\Core\LogsManager;
use DisciteDB\Core\SecurityManager;
use DisciteDB\Core\TablesManager;
use DisciteDB\Core\UsersManager;
use DisciteDB\QueryHandler\QueryResult;
use DisciteDB\Sql\Loading\HandlerDatabase;
use DisciteDB\Sql\Loading\HandlerFile;
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
     * @var DebugManager Debug manager instance.
     */
    protected DebugManager $debugManager;


    /**
     * @var ?array map of SQL file or from SQL Database.
     */
    protected ?array $sqlMap;


    protected string|int|null $environment = null;

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
        $this->debugManager = new DebugManager($this);
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
     * Access the debug manager.
     * 
     * @return DebugManager Users manager instance.
     */
    public function debug(): DebugManager
    {
        return $this->debugManager;
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
    public function table(string $name): QueryResult|TableInterface
    {
        return $this->getTable($name);
    }


    /**
     * Retrieve SQL map.
     * 
     * Return SQL map if you decide to load database from SQL requests or file.
     * 
     * @return ?array Returns the multidmentional array of map if exist.
     * 
     */
    public function map() : ?array
    {
        return $this->sqlMap;
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
    public function __get(string $name): QueryResult|TableInterface
    {
        return $this->getTable($name);
    }

    /**
     * Load tables and keys from database.
     * 
     * Allow you to stay in strict mode without defining each tables and keys.
     * 
     * @return void
     *
     */
    public function loadFromDatabase() : void
    {
        $this->sqlMap = (new HandlerDatabase($this->connection()->get(), $this))->getArray();
    }

    /**
     * Load tables and keys from cache file.
     * 
     * Allow you to stay in strict mode without defining each tables and keys.
     * 
     * @param string $path put the absolute path to get into cache file
     * @param int $updatingTime Insert here the time you want library to update your file from database
     * 
     * @return void
     *
     */
    public function loadFromFile(string $path, int $updatingTime) : void
    {
        $this->sqlMap = (new HandlerFile($path, $updatingTime, $this->connection()->get(), $this))->getArray();
    }

    public function setEnvironment(string|int $environment) : void
    {
        $this->environment = $environment;
    }

    public function getEnvironment() : string|int|null
    {
        return $this->environment;
    }


    /**
     * Internal method to retrieve a table by name, considering table usage configuration.
     * 
     * @param string $name Table name.
     * 
     * @return TableInterface Table interface instance.
     * @return QueryResult Throws exception if table is not defined.
     * 
     */
    private function getTable(string $name): TableInterface|QueryResult
    {
        $table = ($this->config()->getTableUsage() === TableUsage::LooseUsage)
            ? $this->tables()->create($name, ['alias' => $name])->getName()
            : $name;

        return $this->tables()->getTable($table);
    }
}

?>

