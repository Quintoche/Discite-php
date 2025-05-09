<?php
namespace DisciteDB;

class Database
{

    protected Connection $connection;

    protected Configuration $configuration;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection ?? new Connection();

        $this->configuration = new Configuration($this);
    }


    public function config() : Configuration
    {
        return $this->configuration;
    }

    public function __get(string $name)
    {
        return $this->configuration->tables->getTable($name) ?? throw new \Exception("Table '$name' not defined.");
    }
}

?>