<?php

namespace DisciteDB\Methods\ConditionHandlers;

class HandlerMoreOrEqual extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} >= {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>