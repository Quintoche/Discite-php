<?php
namespace DisciteDB\Core;

use DisciteDB\Configuration;
use DisciteDB\Tables\Table;

class LogsManager
{
    private Configuration $configuration;

    protected bool $enableLogs = false;

    protected Table $selectedTable;

    protected bool $enableSanitize = false;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    public function enableLogs(bool $value) : void
    {
        $this->enableLogs = $value;
    }

    public function setTable(Table $value) : void
    {
        $this->selectedTable = $value;
    }

    public function createTable(string $tableName) : void
    {
        $this->selectedTable = $this->configuration->tables->create($tableName);
    }
}

?>