<?php

namespace DisciteDB\Methods\Handlers;

class HandlerBetween extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ' AND ';

    protected string $templateForm = '{KEY} BETWEEN {UNIQUE}';
}

?>