<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\NamingConvention;
use DisciteDB\DisciteDB;

class NamingConfig
{

    /**
     * Global naming convention to use across the library.
     *
     * You can override this value at runtime.
     *
     * @var \DisciteDB\Config\Enums\NamingConvention NamingConvention
     */
    public static NamingConvention $NAMING_CASE = DisciteDB::NAMING_CONVENTION_UNDEFINED;
    
}

?>