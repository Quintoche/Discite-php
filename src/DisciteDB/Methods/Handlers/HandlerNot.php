<?php

namespace DisciteDB\Methods\Handlers;


class HandlerNot extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} != {VALUE}';

    protected string $templateSeparator = ' ';

    protected string $templateForm = '{UNIQUE}';
}

?>