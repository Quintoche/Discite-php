<?php

namespace DisciteDB\Methods\Clauses;

class ClauseSort extends AbstractBaseClause implements ArgumentClauseInterface
{
    protected string $templateUnique = 'ORDER BY {KEY} {VALUE}';

    protected string $templateSeparator = '';

    protected string $templateForm = '{UNIQUE}';
}

?>