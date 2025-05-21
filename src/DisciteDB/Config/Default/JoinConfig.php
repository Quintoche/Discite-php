<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\JoinMethod;
use DisciteDB\DisciteDB;

class JoinConfig
{
    
    /**
     * Default max iterations for joining query
     *
     * You can override this value at runtime. Default value to 0 perform a no maximum query joining.
     *
     * @var int MAX_ITERATIONS
     */
    public static int $MAX_ITERATIONS = 0;
    
    /**
     * Default join method
     *
     * You can override this value at runtime. Default value to flat method
     *
     * @var \DisciteDB\Config\Enums\JoinMethod JoinMethod
     */
    public static JoinMethod $JOIN_METHOD = DisciteDB::JOIN_METHOD_FLAT;
    
    /**
     * Default join separator
     *
     * You can override this value at runtime.
     * Only used when using "concat" joining method.
     *
     * @var string JOIN_SEPERATOR
     */
    public static string $JOIN_SEPERATOR = ', ';
    
}

?>