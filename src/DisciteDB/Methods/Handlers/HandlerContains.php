<?php

namespace DisciteDB\Methods\Handlers;

class HandlerContains extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} LIKE {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>