<?php

namespace DisciteDB\Methods\Handlers;

class HandlerOr extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} = {VALUE}';

    protected string $templateSeparator = ' OR ';

    protected string $templateForm = '({UNIQUE})';
}

?>