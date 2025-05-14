<?php

namespace DisciteDB\Methods\Handlers;

class HandlerNotLike extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} NOT LIKE {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>