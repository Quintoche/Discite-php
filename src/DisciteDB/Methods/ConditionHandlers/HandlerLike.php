<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerLike extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{TABLE}.{KEY} LIKE {VALUE}';

    protected string $templateSeparator = '';

    protected string $templateForm = '{UNIQUE}';

    protected QueryCondition $modifier = QueryCondition::Like;
}

?>