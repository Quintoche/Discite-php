<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerNotLike extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{TABLE}.{KEY} NOT LIKE {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';

    protected QueryCondition $modifier = QueryCondition::NotLike;
}

?>