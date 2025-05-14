<?php
namespace DisciteDB\Keys;

use DisciteDB\Config\Enums\Operators;

trait KeyTraitMap
{
    public function appendOperator(Operators $operator) : void
    {
        $this->map[$operator->value] = $operator;
    }

    public function revokeOperator(Operators $operator) : void
    {
        unset($this->map[$operator->value]);
    }
}

?>