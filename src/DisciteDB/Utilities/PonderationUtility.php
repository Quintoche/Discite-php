<?php

namespace DisciteDB\Utilities;

use DisciteDB\Sql\Data\DataValue;
use DisciteDB\Tables\BaseTable;
use mysqli;

class PonderationUtility
{
    protected BaseTable $table;

    protected mysqli $connection;

    protected mixed $argument;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function setTable(BaseTable $table) : self
    {
        $this->table = $table;
        return $this;
    }
    public function setArgument(mixed $argument) : self
    {
        $this->argument = DataValue::escape($argument,$this->connection);
        return $this;
    }

    public function handle() : string
    {

        


        return '';
    }
}

?>