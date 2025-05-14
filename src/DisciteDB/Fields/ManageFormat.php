<?php

namespace DisciteDB\Fields;

use DisciteDB\Keys\BaseKey;

use DisciteDB\Config\Enums\TypeBinary;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeString;

class ManageFormat
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
        if(!$this->value) return true;

        return match (true) 
        {
            $this->type instanceof TypeString => $this->checkString(),
            $this->type instanceof TypeDate => $this->checkDate(),
            $this->type instanceof TypeBinary => $this->checkBinary(),
            default => true
        };
    }

    private function checkString() : bool
    {
        return match ($this->type) 
        {
            TypeString::URL => (bool) filter_var($this->value,FILTER_VALIDATE_URL),
            TypeString::Email => (bool) filter_var($this->value,FILTER_VALIDATE_EMAIL),
            TypeString::IP => (bool) filter_var($this->value,FILTER_VALIDATE_IP),
            default => true
        };
    }

    private function checkDate() : bool
    {
        return match ($this->type) 
        {
            TypeDate::Date => (bool) preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->value),
            TypeDate::DateTime, TypeDate::Timestamp => (bool) preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $this->value),
            TypeDate::Time => (bool) preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->value),
            TypeDate::Year => (bool) preg_match('/^\d{4}$/', $this->value),
            default => false
        };

        
    }

    private function checkBinary() : bool
    {
        if ($this->type === TypeBinary::Json) {
            if (is_string($this->value)) {
                return (bool) json_validate($this->value);
            }
    
            if (is_object($this->value) || is_array($this->value)) {
                return (bool) json_validate(json_encode($this->value));
            }
        }
        return true;
    }
}
?>