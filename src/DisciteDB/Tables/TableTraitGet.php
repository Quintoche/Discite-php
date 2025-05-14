<?php
namespace DisciteDB\Tables;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Keys\BaseKey;

trait TableTraitGet
{
    public function getName() : string|null
    {
        return $this->name ?? null;
    }

    public function getAlias() : string|null
    {
        return $this->alias ?? null;
    }

    public function getPrefix() : string|null
    {
        return $this->prefix ?? null;
    }

    public function getIndexKey() : BaseKey|null
    {
        return $this->indexKey ?? null;
    }

    public function getMap() : array|null
    {
        return $this->map ?? null;
    }

    public function getAll() : array
    {
        return [
            'name' => $this->name,
            'alias' => $this->alias,
            'prefix' => $this->prefix,
            'type' => $this->type,
            'indexKey' => $this->indexKey,
        ];
    }

    public function getMagicValue(string $key) : mixed
    {
        if(property_exists($this, $key))
        {
            return $this->{$key};
        }
        
        return null;
    }

    public function validateField(Operators $operators, mixed $value) : bool
    {
        $this->field->setOperator($operators);
        $this->field->setValue($value);

        return $this->field->validateField();
    }

    public function generateField() : mixed
    {
        return $this->field->generateField();
    }
    
}

?>