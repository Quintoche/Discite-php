<?php

namespace DisciteDB\Fields;

use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\Operators;
use DisciteDB\Keys\BaseKey;

use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class ManageOptions
{

    protected BaseKey $key;

    protected Operators $operator;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type;

    protected mixed $value;

    public function __construct(BaseKey $key, Operators $operator, mixed $value)
    {
        $this->key = $key;

        $this->operator = $operator;

        $this->type = $this->key->getType();

        $this->value = $value;
    }

    public function checking() : bool
    {
        $returning = [];
        switch($this->operator)
        {
            case Operators::Update:
                $returning[] = $this->checkUpdatable();
                $returning[] = $this->checkNullable();
                break;
            case Operators::Create:
                $returning[] = $this->checkNullable();
                break;
            default:
                $returning[] = true;
        }

        return !(in_array(false,$returning));
    }

    private function CheckUpdatable() : bool
    {
        if($this->key->getUpdatable()) return true;
        return false;
    }
    private function checkNullable()
    {
        if($this->key->getNullable()) return true;
        if($this->value) return true;
        if(self::hasEffectiveDefault($this->key))
        {
            return (new ManageDefault($this->key))->checking();
        }

        return false;
    }


    private static function hasEffectiveDefault(BaseKey $key): bool
    {
        return !in_array($key->getDefault(), [DefaultValue::Null, DefaultValue::EmptyString], true);
    }
    
}
?>