<?php

namespace DisciteDB\Methods\Clauses;

interface ArgumentClauseInterface
{
    public function toSql(): string;
}

?>