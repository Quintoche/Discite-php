<?php

namespace DisciteDB\Fields;

use DisciteDB\Config\Enums\Operators;
use DisciteDB\Keys\BaseKey;
use DisciteDB\Methods\QueryConditionExpression;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeInteger;

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
        return ($this->value === null && !$this->key->getNullable()) ? (new ManageDefault($this->key))->returnDefault() : $this->formatValue($this->value);
    }


    private function validateIni(mixed $value) : bool
    {
        if($this->isLooseUsage()) return true;
        
        $lookedValue = ($value instanceof QueryConditionExpression) ? $value->returnArgs() : $this->formatValue($value);


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

    private function formatValue(mixed $value)
    {
        if(is_array($value)) return $value;

        if($this->key->getType() instanceof TypeDate)
        {
            return match ($this->key->getType()) 
            {
                TypeDate::Date => date('Y-m-d',strtotime($value)),
                TypeDate::DateTime, TypeDate::Timestamp => date('Y-m-d H:i:s',strtotime($value)),
                TypeDate::Time => date('H:i:s',strtotime($value)),
                TypeDate::Year => date('Y',strtotime($value)),
                default => $value,
            };
        }
        elseif($this->key->getType() instanceof TypeInteger)
        {
            return match ($this->key->getType()) 
            {
                TypeInteger::Boolean => ($value == 'true' || $value == true || $value == 1) ? true : false,
                TypeInteger::BigInt => $value,
                default => $value,
            };
        }
        return $value;
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

    private function isLooseUsage() : bool
    {
        return $this->key->getLooseUsage();
    }
}
?>