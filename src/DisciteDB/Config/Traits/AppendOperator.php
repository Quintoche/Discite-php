<?php
namespace DisciteDB\Config\Traits;

use DisciteDB\Operators\Operator;

trait AppendOperator
{   
    public function appendOperator(Operator $operator) : void
    {
        $this->map[$operator->getAlias() ?? $operator->getName()] = $operator;
    }
}

?>