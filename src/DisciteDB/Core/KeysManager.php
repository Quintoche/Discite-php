<?php
namespace DisciteDB\Core;

use DisciteDB\Configuration;
use DisciteDB\Keys\Key;

class KeysManager
{
    private Configuration $configuration;

    protected array $map = [];

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    public function create(string $keyName, ?array $parms = []) : Key
    {
        $class = new Key();

        $class->updateVariable('name',$keyName);
        foreach($parms as $k => $v)
        {
            $class->updateVariable($k,$v);
        }

        $keyAlias = $parms['alias'] ?? $keyName;
        $class->updateVariable('alias',$keyAlias);

        $this->registerKey($keyAlias,$class);

        return $class;
    }

    public function update(string $keyName, ?array $parms = []) : void
    {
        $class = $this->returnClassInMap($keyName);

        foreach($parms as $k => $v)
        {
            $class->updateVariable($k,$v);
        }

        $keyAlias = $class->getAlias() ?? $parms['alias'] ?? $keyName;

        $this->registerKey($keyAlias,$class);
    }

    public function delete(string $keyName) : void
    {
        $class = $this->returnClassInMap($keyName);
        unset($class);
    }

    public function retrieveFromDatabase(string $tableName) : void
    {

    }

    private function registerKey(string $keyAlias, Key $keyClass) : void
    {
        $this->map[$keyAlias] = $keyClass;
    }

    private function returnClassInMap(string $className) : null|Key
    {
        $key = $this->map[$className] ?? null;
        if(!$key) throw new \Exception("Key '$className' not found");

        return $key;
            
    }

}

?>