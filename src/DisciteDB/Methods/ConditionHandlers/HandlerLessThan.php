<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerLessThan extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{TABLE}.{KEY} < {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';

    protected QueryCondition $modifier = QueryCondition::LessThan;
}

?>