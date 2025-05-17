<?php

namespace DisciteDB\Methods\Clauses;

class ClauseLimit extends AbstractBaseClause implements ArgumentClauseInterface
{
    protected string $templateUnique = '{KEY} LIKE {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>