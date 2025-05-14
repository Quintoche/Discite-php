<?php

namespace DisciteDB\Fields;

use DisciteDB\Config\Default\TypeConfig;
use DisciteDB\Keys\BaseKey;

use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class ManageSize
{

    protected BaseKey $key;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type;

    protected mixed $value;

    protected mixed $length;

    public function __construct(BaseKey $key, mixed $value)
    {
        $this->key = $key;

        $this->type = $this->key->getType();

        $this->value = $value;

        $this->length = TypeConfig::$LENGTH_MAP[$this->type->name] ?? null;
    }

    public function checking() : bool
    {
        if(!$this->value) return true;
        if(!$this->length || $this->length == 0) return true;

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
        return (mb_strlen((string) $this->value) <= $this->length);
    }

    private function checkDate() : bool
    {
        return true;
    }

    private function checkFloat() : bool
    {
        [$precision, $scale] = (count($this->length) == 2) ? $this->length : [10,2];

        $parts = explode('.', number_format((float)$this->value, $scale, '.', ''));
        $intPartLength = strlen($parts[0]);
        $decPartLength = isset($parts[1]) ? strlen($parts[1]) : 0;

        return ($intPartLength + $decPartLength) <= $precision && $decPartLength <= $scale;
    }

    private function checkInteger() : bool
    {
        return (strlen((string) abs((int) $this->value)) <= $this->length);
    }

    private function checkBinary() : bool
    {
        return (strlen((string) $this->value) <= $this->length);
    }
}
?>