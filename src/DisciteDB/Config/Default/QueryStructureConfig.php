<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\QueryStructure;
use DisciteDB\Config\Enums\QueryTemplate;

class QueryStructureConfig
{
    
    public static array $MAP = 
    [
        QueryStructure::Base->name  => [
            QueryTemplate::Select->name => 'SELECT',
            QueryTemplate::SelectAll->name => 'SELECT',
            QueryTemplate::Update->name => 'UPDATE',
            QueryTemplate::Insert->name => 'INSERT INTO',
            QueryTemplate::Delete->name => 'DELETE FROM',
        ],        
        QueryStructure::Structure->name  => [
            QueryTemplate::Select->name => '{COLUMNS} FROM {DATABASE}.{TABLE}',
            QueryTemplate::SelectAll->name => '{COLUMNS} FROM {DATABASE}.{TABLE}',
            QueryTemplate::Update->name => '{DATABASE}.{TABLE}',
            QueryTemplate::Insert->name => '{DATABASE}.{TABLE}',
            QueryTemplate::Delete->name => '{DATABASE}.{TABLE}',
        ],        
        QueryStructure::Methods->name  => [
            QueryTemplate::Select->name => 'LEFT JOIN {TABLE_FOREIGN} ON {TABLE}.{INDEX_KEY} = {TABLE_FOREIGN}.{FOREIGN_PRIMARY_KEY}',
            QueryTemplate::SelectAll->name => null,
            QueryTemplate::Update->name => null,
            QueryTemplate::Insert->name => null,
            QueryTemplate::Delete->name => null,
        ],        
        QueryStructure::Datas->name  => [
            QueryTemplate::Select->name => null,
            QueryTemplate::SelectAll->name => null,
            QueryTemplate::Update->name => 'SET {CONDITIONS}',
            QueryTemplate::Insert->name => '({KEYS}) VALUES ({VALUES})',
            QueryTemplate::Delete->name => null,
        ],        
        QueryStructure::Conditions->name  => [
            QueryTemplate::Select->name => 'WHERE {CONDITIONS} {UUID} {MODIFIER}',
            QueryTemplate::SelectAll->name => '{MODIFIER}',
            QueryTemplate::Update->name => 'WHERE {UUID}',
            QueryTemplate::Insert->name => null,
            QueryTemplate::Delete->name => 'WHERE {UUID}',
        ],  
     
    ];

}

?>