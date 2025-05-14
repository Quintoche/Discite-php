<?php

namespace DisciteDB\Methods\Handlers;

class HandlerLessOrEqual extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} <= {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>