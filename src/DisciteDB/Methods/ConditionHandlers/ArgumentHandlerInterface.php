<?php

namespace DisciteDB\Methods\ConditionHandlers;

interface ArgumentHandlerInterface
{
    public function toSql(): string;
}

?>