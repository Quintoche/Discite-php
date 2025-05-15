<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\TableUsage;
use DisciteDB\Config\Enums\KeyUsage;
use DisciteDB\DisciteDB;

class UsageConfig
{
    
    /**
     * Default value defined for table usage
     *
     * You can override this value at runtime.  Default value is StrictUsage. You, so, must declare tables before used them
     *
     * @var TableUsage Default : StrictUsage
     */
    public static TableUsage $TABLE_USAGE = DisciteDB::TABLE_USAGE_STRICT;
    
    /**
     * Default value defined for key usage
     *
     * You can override this value at runtime. Default value is StrictUsage. You, so, must declare Keys before used them
     *
     * @var KeyUsage Default : StrictUsage
     */
    public static KeyUsage $KEY_USAGE = DisciteDB::KEY_USAGE_STRICT;
    
}

?>