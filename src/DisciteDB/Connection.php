<?php
namespace DisciteDB;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Exceptions\ConnectionException;
use mysqli;

/**
 * Class Connection
 * 
 * Responsible for managing the MySQLi connection.
 * Supports creation of a new connection or wrapping an existing one.
 * Handles connection validation and database initialization.
 * 
 * @package DisciteDB
 */
class Connection
{

    /**
     * @var string|null Hostname for MySQL connection.
     */
    private ?string $hostname;


    /**
     * @var string|null Username for MySQL connection.
     */
    private ?string $username;


    /**
     * @var string|null Password for MySQL connection.
     */
    private ?string $password;


    /**
     * @var string|null Database name to connect to.
     */
    private ?string $database;


    /**
     * @var int|null Port number for MySQL connection.
     */
    private ?int $port;


    /**
     * @var mysqli MySQLi connection instance.
     */
    protected mysqli $mysqli;


    /**
     * Connection constructor.
     * 
     * If an external MySQLi connection is provided, it wraps it;
     * otherwise, creates a new connection using configuration defaults.
     * Validates the connection and sets the current database context.
     * 
     * @param mysqli|null $connection Optional existing MySQLi connection.
     * @throws ConnectionException Throws if connection fails.
     */
    public function __construct(?mysqli $connection = null)
    {
        $this->mysqli = $this->createExternConnection($connection) ?? $this->createInternalConnection();

        self::checkConnection($this->mysqli);
        self::createDatabase($this->mysqli);
    }


    /**
     * Attempts to use an externally provided MySQLi connection.
     * 
     * @param mysqli|null $connection External MySQLi connection.
     * 
     * @return mysqli|null Returns the external connection if provided; null otherwise.
     */
    private function createExternConnection(?mysqli $connection = null): ?mysqli
    {
        return $connection ?? null;
    }


    /**
     * Creates a new MySQLi connection using default config constants.
     * 
     * @return mysqli Returns a new MySQLi connection instance.
     */
    private function createInternalConnection(): mysqli
    {
        $this->hostname = ConnectionConfig::DEFAULT_HOSTNAME;
        $this->username = ConnectionConfig::DEFAULT_USERNAME;
        $this->password = ConnectionConfig::DEFAULT_PASSWORD;
        $this->database = ConnectionConfig::DEFAULT_DATABASE;
        $this->port = ConnectionConfig::DEFAULT_PORT;

        return new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
    }


    /**
     * Destructor closes the MySQLi connection.
     */
    public function __destruct()
    {
        // @$this->mysqli->close();
    }


    /**
     * Gets the current MySQLi connection instance.
     * 
     * @return mysqli Returns the active MySQLi connection.
     */
    public function get(): mysqli
    {
        return $this->mysqli;
    }


    /**
     * Sets the current database name in the configuration based on the connection.
     * 
     * @param mysqli $connection Active MySQLi connection.
     * 
     * @return void
     */
    private static function createDatabase(mysqli $connection) : void
    {
        $db = mysqli_fetch_row(mysqli_query($connection, "SELECT DATABASE()"))[0];
        ConnectionConfig::$DATABASE = $db;
    }


    /**
     * Validates that the MySQLi connection has no errors.
     * Throws a ConnectionException if connection failed.
     * 
     * @param mysqli $connection Active MySQLi connection.
     * 
     * @return void
     * 
     * @throws ConnectionException If connection error occurs.
     */
    private static function checkConnection(mysqli $connection) : void
    {
        if ($connection->connect_error) {
            throw new ConnectionException(
                "Failed to connect to MySQL: " . $connection->connect_error,
                $connection->connect_errno
            );
        }
    }
}

?>
