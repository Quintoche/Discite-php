<?php
namespace DisciteDB\Core;

use DisciteDB\Config\Traits\KeysManager\Create;
use DisciteDB\Database;
use DisciteDB\Keys\BaseKey;
use DisciteDB\QueryHandler\QueryResult;
use DisciteDB\Utilities\NameSanitizer;

class KeysManager
{
    use Create;
    
    private Database $database;

    protected array $map = [];

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function create(string $keyName, ?array $parms = []) : BaseKey
    {

        $className = $this->returnTemplateKeys($keyName) ?? '\\DisciteDB\\Keys\\CustomKey';
        $class = new $className($this->database);

        $class->setName($keyName);
        foreach($parms as $k => $v)
        {
            $class->setMagicValue($k,$v);
        }

        $class->setAlias($parms['alias'] ?? $class->getAlias() ?? $keyName);

        $this->registerKey($keyName,$class);

        return $class;
    }

    public function update(string $keyName, ?array $parms = []) : void
    {
        $class = $this->returnClassInMap($keyName);

        foreach($parms as $k => $v)
        {
            $class->setMagicValue($k,$v);
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

    protected function registerKey(string $keyAlias, BaseKey $keyClass) : void
    {
        $this->map[$keyAlias] = $keyClass;
    }

    protected function returnClassInMap(string $className) : null|BaseKey
    {
        $key = $this->map[$className] ?? null;
        if(!$key) throw new \Exception("Key '$className' not found");

        return $key;
    }
    protected function returnTemplateKeys(string $className) : null|string
    {
        return (class_exists('\\DisciteDB\\Keys\\KeyTemplates\\Template'.$className)) ? '\\DisciteDB\\Keys\\KeyTemplates\\Template'.$className : null;
    }

    public function __get($name) : QueryResult|BaseKey
    {
        $key = $this->map[$name] ?? $this->map[NameSanitizer::sanitize($name)] ?? null;
        if(!$key) return $this->callException($name);

        return $key;
    }

    private function callException($keyName)  : QueryResult
    {
        return (new QueryManager($this->database))->makeQuery(new ExceptionsManager("Key '$keyName' not found",404,'Database'));
    }

}

?>