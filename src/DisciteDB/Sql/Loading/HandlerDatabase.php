<?php
namespace DisciteDB\Sql\Loading;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Database;
use DisciteDB\QueryHandler\QueryResult;
use mysqli;

class HandlerDatabase
{
    protected mysqli $connection;

    protected Database $database;

    protected array $array;

    protected array $tables;

    protected array $keys;

    protected array $keysIndex;


    public function __construct(mysqli $connection, Database $database)
    {
        $this->connection = $connection;

        $this->database = $database;

        $this->array = $this->retrieveArray();

        $this->retrieve();

        $this->updateKeys();
        
    }

    public function getArray() : ?array
    {
        return $this->array;
    }

    private function retrieveArray() : array
    {
        return LoadingQuery::makeQuery($this->connection);
    }

    private function retrieve() : void
    {
        foreach($this->array as $table => $infos)
        {
            $_table = LoadingTables::create($table,$this->database);

            $this->tables[] = $_table;

            $_keys = [];
            foreach($infos['columns'] as $key => $info)
            {
                $_key = LoadingKeys::create($info,$info['index'],$this->database);
                if(LoadingKeys::isPrimaryKey($_key)) LoadingTables::addPrimaryKey($_table, $_key, $this->database);

                $_keys[] = $_key;
                $this->keys[$table][$key] = $info;
            }

            LoadingTables::appendKeys($table,$_keys,$this->database);

        }
    }

    private function updateKeys() : void
    {
        foreach($this->tables as $table)
        {
            foreach($this->keys[$table->getName()] as $k => $key)
            {
                if(!isset($this->keys[$table->getName()][$k]['index']['referenced_table'])) 
                {
                    if($this->database->keys()->{$table->getName().'_'.$k}->getIndex() == IndexType::Index) $this->database->keys()->update($table->getName().'_'.$k,['index'=>IndexType::None]);
                    continue;
                }
                if(is_null($this->keys[$table->getName()][$k]['index']['referenced_table'])) 
                {
                    if($this->database->keys()->{$table->getName().'_'.$k}->getIndex() == IndexType::Index) $this->database->keys()->update($table->getName().'_'.$k,['index'=>IndexType::None]);
                    continue;
                }


                $_table = $this->database->tables()->getTable($this->keys[$table->getName()][$k]['index']['referenced_table']) ?? null;
                if($_table instanceof QueryResult || is_null($_table))
                {
                    $this->database->keys()->update($table->getName().'_'.$k,['index'=>IndexType::None]);
                    continue;
                }

                $this->database->keys()->update($table->getName().'_'.$k,['indexTable'=>$_table]);

            }
        }
    }

}

?>