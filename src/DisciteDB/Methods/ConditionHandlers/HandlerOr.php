<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerOr extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{TABLE}.{KEY} = {VALUE}';

    protected string $templateSeparator = ' OR ';

    protected string $templateForm = '({UNIQUE})';

    protected QueryCondition $modifier = QueryCondition::Or;
}

?>