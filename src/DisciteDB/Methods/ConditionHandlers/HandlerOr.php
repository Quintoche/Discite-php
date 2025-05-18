<?php

namespace DisciteDB\Methods\ConditionHandlers;

class HandlerOr extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{KEY} = {VALUE}';

    protected string $templateSeparator = ' OR ';

    protected string $templateForm = '({UNIQUE})';
}

?>