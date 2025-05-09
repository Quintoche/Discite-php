<?php
namespace DisciteDB;

use DisciteDB\Config\Default\ConnectionConfig;
use DisciteDB\Exceptions\ConnectionException;

use mysqli;

class Connection
{

    protected string $hostname;

    protected string $username;

    protected string $password;

    protected string $database;


    public mysqli $connection;


    public function __construct(string $hostname = ConnectionConfig::DB_HOSTNAME, string $username = ConnectionConfig::DB_USERNAME, string $password = ConnectionConfig::DB_PASSWORD, string $database = ConnectionConfig::DB_DATABASE) 
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        self::checkConnection($this->connection);
    }

    public function __destruct()
    {
        @$this->connection->close();
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