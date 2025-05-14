<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\QueryTemplate;
use DisciteDB\Config\Enums\QueryType;

class QueryTemplateConfig
{
    
    public static array $MAP = 
    [
        QueryTemplate::Select->name     => [QueryType::Base,QueryType::Structure,QueryType::Conditions],
        QueryTemplate::SelectAll->name  => [QueryType::Base,QueryType::Structure,],
        QueryTemplate::Update->name     => [QueryType::Base,QueryType::Structure,QueryType::Datas,QueryType::Conditions],
        QueryTemplate::Insert->name     => [QueryType::Base,QueryType::Structure,QueryType::Datas],
        QueryTemplate::Delete->name     => [QueryType::Base,QueryType::Structure,QueryType::Conditions],       

        'default'                       => [QueryType::Base,QueryType::Structure,QueryType::Methods,QueryType::Datas,QueryType::Conditions],       

        QueryTemplate::CreateTable->name  => 'CREATE TABLE `{DATABSE}`.`{TABLE}` ({KEYS});',        
        QueryTemplate::CreateKey->name  => 'ALTER TABLE `{TABLE}` ADD {KEYS};',        
        QueryTemplate::UpdateKey->name  => 'ALTER TABLE `{TABLE}` CHANGE {KEY} {KEYS};',        
        QueryTemplate::DeleteKey->name  => 'ALTER TABLE `{TABLE}` DROP {KEYS};',        
     
    ];

}

?>