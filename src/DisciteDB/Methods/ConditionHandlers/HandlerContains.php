<?php

namespace DisciteDB\Methods\ConditionHandlers;

class HandlerContains extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} LIKE {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>