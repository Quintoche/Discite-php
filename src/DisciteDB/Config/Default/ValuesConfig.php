<?php

namespace DisciteDB\Config\Default;

class ValuesConfig
{
    
    /**
     * Default charset value
     *
     * You can override this value at runtime.
     *
     * @var string Default : utf8mb4
     */
    public static string $CHARSET = 'utf8mb4';
    
    /**
     * Default collation value
     *
     * You can override this value at runtime.
     *
     * @var string Default : utf8mb4_unicode_ci
     */
    public static string $COLLATION = 'utf8mb4_unicode_ci';
    
}

?>