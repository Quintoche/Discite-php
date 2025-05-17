<?php

namespace DisciteDB\Config\Traits\TablesManager;

use DisciteDB\Tables\BaseTable;

trait Delete
{
    public function delete(string $tableName) : void
    {
        $class = $this->returnClassInMap($this->deleteGetTable($tableName)->getName());
        unset($class);
    }

    protected function deleteGetTable(BaseTable|string $table) : ?BaseTable
    {
        return match (true) {
            $table instanceof BaseTable => $table,
            $this->database->tables()->$table => $this->database->tables()->$table,
            default => null,
        };
    }

}

?>