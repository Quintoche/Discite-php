<?php
namespace DisciteDB\Keys;

use DisciteDB\Config\Enums\IndexType;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Tables\BaseTable;

trait KeyTraitGet
{
    /**
     * Retourne le nom de la clé.
     *
     * @return string|null
     */
    public function getName() : string|null
    {
        return $this->name ?? null;
    }

    /**
     * Retourne l'alias de la clé.
     *
     * @return string|null
     */
    public function getAlias() : string|null
    {
        return $this->alias ?? null;
    }

    /**
     * Retourne le prefix de la clé.
     *
     * @return string|null
     */
    public function getPrefix() : string|null
    {
        return $this->prefix ?? null;
    }

    /**
     * Retourne le type de la clé.
     *
     * @return TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary|null
     */
    public function getType() : TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary|null
    {
        return $this->type ?? null;
    }

    /**
     * Retourne le type d'index de la clé.
     *
     * @return IndexType|null
     */
    public function getIndex() : IndexType|null
    {
        return $this->index ?? null;
    }

    /**
     * Retourne la table sur laquelle cette clé est indéxée (s'il s'agit d'un indexType::Index)
     *
     * @return BaseTable|null
     */
    public function getIndexTable() : BaseTable|null
    {
        return $this->indexTable ?? null;
    }

    /**
     * Retourne la valeur par défaut de la clé
     *
     * @return mixed
     */
    public function getDefault() : mixed
    {
        return $this->default ?? null;
    }

    public function getNullable() : bool|null
    {
        return $this->nullable ?? null;
    }

    public function getSecure() : bool|null
    {
        return $this->secure ?? null;
    }

    public function getUpdatable() : bool|null
    {
        return $this->updatable ?? null;
    }

    public function getLooseUsage() : bool|null
    {
        return $this->looseUsage ?? null;
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
            'index' => $this->index,
            'default' => $this->default,
            'nullable' => $this->nullable,
            'secure' => $this->secure,
            'updatable' => $this->updatable,
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