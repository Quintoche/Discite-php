<?php

namespace DisciteDB\Utilities;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Sql\Data\DataKey;
use DisciteDB\Sql\Data\DataTable;
use DisciteDB\Sql\Data\DataValue;
use DisciteDB\Tables\BaseTable;
use mysqli;

class PonderationUtility
{
    protected BaseTable $table;

    protected mysqli $connection;

    protected Database $database;

    protected mixed $argument;

    protected array $foreignKeys;

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
        $this->argument = $argument;
        return $this;
    }
    public function setInstance(Database $database) : self
    {
        $this->database = $database;
        return $this;
    }

    public function setForeign(?array $foreign) : self
    {
        $this->foreignKeys = $foreign;
        return $this;
    }

    public function handle() : string
    {

        // CASE 1
        $_keys = $this->foreignKeys[$this->table->getAlias()] ?? $this->foreignKeys[$this->table->getName()];

        $_data = [];

        foreach($this->argument as $arg)
        {

            foreach($_keys as $key)
            {
                if(!is_array($key))
                {
                    $_table = DataTable::escape($this->table->getAlias() ?? $this->table->getName());
                    $_key = DataKey::escape($key, $this->connection);
                    $_value = array_values($arg)[0]->returnValues()[0];
                    $_weight = $this->giveWeight($this->database->keys()->{($this->table->getAlias() ?? $this->table->getName()).'_'.$key},$_value);

                    $_data[] = $this->searchReplace("(CASE WHEN {TABLE}.{KEY} = '{VALUE}' THEN {WEIGHT_EQUAL} WHEN {TABLE}.{KEY} LIKE '{VALUE}%' THEN {WEIGHT_START} WHEN {TABLE}.{KEY} LIKE '%{VALUE}%' THEN {WEIGHT_CONTAINS} ELSE 0 END)",[
                        'TABLE' => $_table,
                        'KEY' => $_key,
                        'VALUE' => $_value,
                        'WEIGHT_EQUAL' => intval($_weight + 60),
                        'WEIGHT_START' => intval($_weight + 30),
                        'WEIGHT_CONTAINS' => intval($_weight),
                    ]);
                }
                else
                {
                    foreach($key as $table => $data)
                    {
                        foreach($data as $k => $v)
                        {
                            $_table = DataTable::escape($table);
                            $_key = DataKey::escape($v, $this->connection);
                            $_value = array_values($arg)[0]->returnValues()[0];
                            $_weight = $this->giveWeight($this->database->keys()->{$table.'_'.$v},$_value);

                            $_data[] = $this->searchReplace("(CASE WHEN {TABLE}.{KEY} = '{VALUE}' THEN {WEIGHT_EQUAL} WHEN {TABLE}.{KEY} LIKE '{VALUE}%' THEN {WEIGHT_START} WHEN {TABLE}.{KEY} LIKE '%{VALUE}%' THEN {WEIGHT_CONTAINS} ELSE 0 END)",[
                                'TABLE' => $_table,
                                'KEY' => $_key,
                                'VALUE' => $_value,
                                'WEIGHT_EQUAL' => intval(($_weight + 60) / 1.5),
                                'WEIGHT_START' => intval(($_weight + 30) / 1.5),
                                'WEIGHT_CONTAINS' => intval($_weight / 1.5),
                            ]);
                        }
                    }
                    // foreignTable
                }
            }

        }

        return '';
        return '('.implode(' + ',$_data).') as '.DataKey::escape('weightPertinence',$this->connection);
    }


    private function searchReplace(string $haystack, array|string $needle) : string
    {
        if(is_array($needle))
        {
            foreach($needle as $search => $replace)
            {
                $haystack = str_replace('{'.$search.'}',$replace,$haystack);
            }
            return $haystack;
        }
        else
        {
            return $haystack;
        }
    }

    private function giveWeight(BaseKey $key, mixed $value) : int
    {
        $weight = 5;

        if(str_contains($key->getName(),'name')) $weight += 50;
        if(str_contains($key->getName(),'subtitle')) $weight += 35;
        if(str_contains($key->getName(),'description')) $weight += 25;

        if($key->getIndex() == IndexType::Unique) $weight += 15;
        if($key->getIndex() == IndexType::FullText) $weight += 15;

        if (is_string($value) && str_contains($value, '_')) {
            $weight -= substr_count($value, '_') * 15;
        }

        return $weight;
    }
}

?>