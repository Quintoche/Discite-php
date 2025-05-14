<?php

namespace DisciteDB\Fields;

use DisciteDB\Keys\BaseKey;

use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class ManageType
{

    protected BaseKey $key;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type;

    protected mixed $value;

    public function __construct(BaseKey $key, mixed $value)
    {
        $this->key = $key;

        $this->type = $this->key->getType();

        $this->value = $value;
    }

    public function checking() : bool
    {
        if($this->value === null) return true;

        return match (true)
        {
            $this->type instanceof TypeString => $this->checkString(),
            $this->type instanceof TypeDate => $this->checkDate(),
            $this->type instanceof TypeFloat => $this->checkFloat(),
            $this->type instanceof TypeInteger => $this->checkInteger(),
            $this->type instanceof TypeBinary => $this->checkBinary(),
            default => false
        };
    }

    private function checkString() : bool
    {
        return (is_string($this->value));
    }

    private function checkDate() : bool
    {
        return $this->checkString();
    }

    private function checkFloat() : bool
    {
        return is_float($this->value) || is_int($this->value);
    }

    private function checkInteger() : bool
    {
        return is_int($this->value);
    }

    private function checkBinary() : bool
    {
        return $this->checkString();
    }
}
?>