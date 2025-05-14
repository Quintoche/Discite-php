<?php

namespace DisciteDB\Methods\Handlers;

class HandlerMoreThan extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} > {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>