<?php

namespace DisciteDB\Methods\ModifierHandlers;

interface ArgumentHandlerInterface
{
    public function toSql(): string;
}

?>