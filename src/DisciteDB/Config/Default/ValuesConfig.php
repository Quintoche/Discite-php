<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\ValuesCharset;
use DisciteDB\Config\Enums\ValuesCollation;
use DisciteDB\DisciteDB;

class ValuesConfig
{
    
    /**
     * Default charset value
     *
     * You can override this value at runtime.
     *
     * @var \DisciteDB\Config\Enums\ValuesCharset ValuesCharset
     */
    public static ValuesCharset $CHARSET = DisciteDB::CHARSET_UTF8MB4;
    
    /**
     * Default collation value
     *
     * You can override this value at runtime.
     *
     * @var \DisciteDB\Config\Enums\ValuesCollation ValuesCollation
     */
    public static ValuesCollation $COLLATION = DisciteDB::COLLATION_UTF8MB4_UNICODE_CI;
    
}

?>