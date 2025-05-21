<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\QueryTemplate;
use DisciteDB\Config\Enums\QueryStructure;

class QueryTemplateConfig
{
    
    public static array $MAP = 
    [
        QueryTemplate::Select->name     => [QueryStructure::Base,QueryStructure::Structure,QueryStructure::Methods,QueryStructure::Conditions],
        QueryTemplate::SelectAll->name  => [QueryStructure::Base,QueryStructure::Structure,],
        QueryTemplate::Update->name     => [QueryStructure::Base,QueryStructure::Structure,QueryStructure::Datas,QueryStructure::Conditions],
        QueryTemplate::Insert->name     => [QueryStructure::Base,QueryStructure::Structure,QueryStructure::Datas],
        QueryTemplate::Delete->name     => [QueryStructure::Base,QueryStructure::Structure,QueryStructure::Conditions],       

        'default'                       => [QueryStructure::Base,QueryStructure::Structure,QueryStructure::Methods,QueryStructure::Datas,QueryStructure::Conditions],            
    ];

}

?>