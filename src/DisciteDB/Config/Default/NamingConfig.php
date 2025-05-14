<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\NamingConvention;

class NamingConfig
{

    /**
     * Global naming convention to use across the library.
     *
     * You can override this value at runtime.
     *
     * @var NamingConvention
     */
    public static NamingConvention $NAMING_CASE = NamingConvention::CamelCase;
    
}

?>