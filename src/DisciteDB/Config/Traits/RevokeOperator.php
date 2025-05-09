<?php
namespace DisciteDB\Config\Traits;

use DisciteDB\Operators\Operator;

trait RevokeOperator
{   
    public function revokeOperator(Operator $operator) : void
    {
        unset($this->map[$operator->getAlias() ?? $operator->getName()]);
    }
}

?>