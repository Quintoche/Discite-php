<?php

namespace DisciteDB\Methods\Handlers;

class HandlerNotBetween extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ' AND ';

    protected string $templateForm = '{KEY} NOT BETWEEN {UNIQUE}';
}

?>