<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerNotBetween extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ' AND ';

    protected string $templateForm = '{TABLE}.{KEY} NOT BETWEEN {UNIQUE}';

    protected QueryCondition $modifier = QueryCondition::NotBetween;
}

?>