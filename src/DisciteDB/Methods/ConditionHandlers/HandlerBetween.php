<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerBetween extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ' AND ';

    protected string $templateForm = '{TABLE}.{KEY} BETWEEN {UNIQUE}';

    protected QueryCondition $modifier = QueryCondition::Between;
}

?>