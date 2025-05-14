<?php

namespace DisciteDB\Methods\Handlers;

interface ArgumentHandlerInterface
{
    public function toSql(): string;
}

?>