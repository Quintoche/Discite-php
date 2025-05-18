<?php

namespace DisciteDB\Methods\ModifierHandlers;

class HandlerSort extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = 'ORDER BY {KEY} {VALUE}';

    protected string $templateSeparator = '';

    protected string $templateForm = '{UNIQUE}';
}

?>