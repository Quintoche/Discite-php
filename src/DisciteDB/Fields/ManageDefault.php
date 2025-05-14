<?php

namespace DisciteDB\Fields;

use DisciteDB\Keys\BaseKey;


use DisciteDB\Config\Enums\DefaultValue;
use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class ManageDefault
{

    protected BaseKey $key;

    protected TypeString|TypeDate|TypeFloat|TypeInteger|TypeBinary $type;

    protected mixed $value;

    public function __construct(BaseKey $key)
    {
        $this->key = $key;

        $this->type = $this->key->getType();

        $this->value = $this->getValue();
    }

    public function checking() : bool
    {
        return match (true) 
        {
            !$this->validateSize() => false,
            !$this->validateType() => false,
            !$this->validateFormat() => false,
            default => true
        };
    }

    public function returnDefault() : mixed
    {
        return $this->getValue();
    }

    private function getValue() : mixed
    {
        return match (true)
        {
            $this->key->getDefault() instanceof DefaultValue => self::callDefault($this->key->getDefault()),
            is_callable($this->key->getDefault()) => call_user_func($this->key->getDefault()),
            default => $this->key->getDefault(),
        };
    }

    private function validateSize() : bool
    {
        return (new ManageSize($this->key, $this->value))->checking();
    }

    private function validateType() : bool
    {
        return (new ManageType($this->key, $this->value))->checking();
    }

    private function validateFormat() : bool
    {
        return (new ManageFormat($this->key, $this->value))->checking();
    }


    private function callDefault(DefaultValue $default) : mixed
    {
        $defaultValue = $default->value;
        $defaultName = $default->name;

        $methodName = 'case'.$defaultName;

        if(!method_exists($this, $methodName))
        {
            throw new \LogicException("Default method $methodName() is not defined.");
        }
        return $this->{$methodName}();
    }


    private function caseNull() : mixed
    {
        return null;
    }
    private function caseCurrentTimestamp() : mixed
    {
        return match ($this->type) 
        {
            TypeDate::Date => date('Y-m-d'),
            TypeDate::DateTime, TypeDate::Timestamp => date('Y-m-d H:i:s'),
            TypeDate::Time => date('H:i:s'),
            TypeDate::Year => date('Y'),
            default => date('Y-m-d'),
        };
    }
    private function caseZero() : mixed
    {
        return '0';
    }
    private function caseEmptyString() : mixed
    {
        return '';
    }
    private function caseUUIDv4() : mixed
    {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    private function caseNow() : mixed
    {
        return $this->caseCurrentTimestamp();
    }
}
?>