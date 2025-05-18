<?php

namespace DisciteDB\Methods\ConditionHandlers;

class HandlerBetween extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ' AND ';

    protected string $templateForm = '{KEY} BETWEEN {UNIQUE}';
}

?>