<?php

namespace DisciteDB\Methods\ConditionHandlers;

class HandlerLike extends AbstractLocateHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} LIKE {VALUE}';

    protected string $templateSeparator = '';

    protected string $templateForm = '{UNIQUE}';
}

?>