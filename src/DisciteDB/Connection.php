<?php
namespace DisciteDB;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Exceptions\ConnectionException;

use mysqli;

class Connection
{

    private ?string $hostname;

    private ?string $username;

    private ?string $password;

    private ?string $database;

    private ?int $port;

    protected mysqli $mysqli;


    public function __construct(?mysqli $connection = null) 
    {

        $this->mysqli = $this->createExternConnection($connection) ?? $this->createInternalConnection();

        self::checkConnection($this->mysqli);
        self::createDatabase($this->mysqli);
    }

    private function createExternConnection(?mysqli $connection = null) : ?mysqli
    {
        return $connection ?? null;
    } 
    private function createInternalConnection() : mysqli
    {
        $this->hostname = ConnectionConfig::DEFAULT_HOSTNAME;
        $this->username = ConnectionConfig::DEFAULT_USERNAME;
        $this->password = ConnectionConfig::DEFAULT_PASSWORD;
        $this->database = ConnectionConfig::DEFAULT_PASSWORD;
        $this->port = ConnectionConfig::DEFAULT_PORT;

        return new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
    }

    public function __destruct()
    {
        @$this->mysqli->close();
    }

    public function get() : mysqli
    {
        return $this->mysqli;
    }

    private static function createDatabase(mysqli $connection) 
    {
        ConnectionConfig::$DATABASE = mysqli_fetch_row(mysqli_query($connection, "SELECT DATABASE()"))[0];
    }

    private static function checkConnection(mysqli $connection) : void
    {
        if($connection->connect_error)
        {
            throw new ConnectionException("Failed to connect to MySQL: " . $connection->connect_error, $connection->connect_errno);
        }
    }
}

?>