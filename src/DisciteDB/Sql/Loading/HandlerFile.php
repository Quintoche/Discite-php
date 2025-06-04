<?php
namespace DisciteDB\Sql\Loading;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Database;
use DisciteDB\QueryHandler\QueryResult;
use mysqli;

class HandlerFile
{
    protected mysqli $connection;

    protected Database $database;

    protected string $path;

    protected int $updatingTime;

    protected ?string $file;

    protected ?array $array;

    protected array $tables;

    protected array $keys;

    protected array $keysIndex;


    public function __construct(string $path, int $updatingTime, mysqli $connection, Database $database)
    {
        $this->connection = $connection;

        $this->database = $database;

        $this->path = $path;

        $this->updatingTime = $updatingTime;

        $this->retrieveFile();

        $this->array = $this->retrieveArray();

        $this->updatingArray();

        $this->retrieve();

        $this->updateKeys();
        
    }

    public function getArray() : ?array
    {
        return $this->array;
    }


    private function retrieveFile() : void
    {
        if (file_exists($this->path)) 
        {
            $this->file = file_get_contents($this->path,true);
        }
        else
        {
            $this->file = null;
        }
    }


    private function retrieveArray() : ?array
    {
        return match (true) 
        {
            is_null($this->file) => null,
            is_array(json_decode($this->file,true)) === true => json_decode($this->file, true),
            is_array($this->file) => $this->file,
            default => [],
        };
    }

    private function updatingArray() : void
    {
        if(!$this->array || is_null($this->array) || $this->array == [] || ($this->array['updated'] + $this->updatingTime < time())) 
        {
            $this->array = LoadingQuery::makeQuery($this->connection);

            $this->array['updated'] = time();

            $_file = fopen($this->path, "w") or die("Unable to open file!");
            $_content = json_encode($this->array);
            fwrite($_file, $_content);
            fclose($_file);
        }
    }

    private function retrieve() : void
    {
        if(isset($this->array['updated'])) unset($this->array['updated']);
        
        foreach($this->array as $table => $infos)
        {
            $_table = LoadingTables::create($table,$this->database);

            $this->tables[] = $_table;

            $_keys = [];
            foreach($infos['columns'] as $key => $info)
            {
                $info['table'] = $_table->getName();

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