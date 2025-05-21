<?php

namespace DisciteDB\Methods\ConditionHandlers;

use DisciteDB\Config\Enums\QueryCondition;

class HandlerNotIn extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ', ';

    protected string $templateForm = '{TABLE}.{KEY} NOT IN ({UNIQUE})';

    protected QueryCondition $modifier = QueryCondition::NotIn;
}

?>