<?php

namespace DisciteDB\Methods\MethodHandlers;

interface ArgumentHandlerInterface
{
    public function toSql(): string;
}

?>