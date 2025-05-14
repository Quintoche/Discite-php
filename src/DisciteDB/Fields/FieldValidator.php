<?php

namespace DisciteDB\Fields;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Methods\QueryExpression;

class FieldValidator
{

    protected BaseKey $key;

    protected Operators $operators;

    protected mixed $value;

    protected mixed $checkingValue;

    public function __construct(BaseKey $key)
    {
        $this->key = $key;
    }

    public function setOperator(Operators $operators) : void
    {
        $this->operators = $operators;
    }

    public function setValue(mixed $value) : void
    {
        $this->value = $value;
    }

    public function validateField() : bool
    {
        return $this->validateIni($this->value);
    }

    public function generateField() : mixed
    {
        return ($this->value === null && !$this->key->getNullable()) ? (new ManageDefault($this->key))->returnDefault() : $this->value;
    }


    private function validateIni(mixed $value) : bool
    {
        $lookedValue = ($value instanceof QueryExpression) ? $value->returnArgs() : $value;

        if(is_array($lookedValue))
        {
            $returning = [];

            foreach($lookedValue as $v)
            {
                $returning[] = $this->validateIni($v);
            }

            return !(in_array(false,$returning));
        }

        return match (true)
        {
            !$this->validateOptions($lookedValue) => false,
            !$this->validateSize($lookedValue) => false,
            !$this->validateType($lookedValue) => false,
            !$this->validateFormat($lookedValue) => false,
            default => true,
        };
    }


    private function validateOptions(mixed $lookedValue) : bool
    {
        return (new ManageOptions($this->key, $this->operators, $lookedValue))->checking();
    }

    private function validateSize(mixed $lookedValue) : bool
    {
        return (new ManageSize($this->key, $lookedValue))->checking();
    }

    private function validateType(mixed $lookedValue) : bool
    {
        return (new ManageType($this->key, $lookedValue))->checking();
    }

    private function validateFormat(mixed $lookedValue) : bool
    {
        return (new ManageFormat($this->key, $lookedValue))->checking();
    }
}
?>