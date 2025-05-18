<?php

namespace DisciteDB\Methods\ConditionHandlers;


class HandlerNotIn extends AbstractBaseHandler implements ArgumentHandlerInterface
{
    protected string $templateUnique = '{VALUE}';

    protected string $templateSeparator = ', ';

    protected string $templateForm = '{KEY} NOT IN ({UNIQUE})';
}

?>