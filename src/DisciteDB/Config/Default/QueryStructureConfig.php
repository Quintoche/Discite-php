<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\QueryStructure;

class QueryStructureConfig
{
    
    public static array $MAP = 
    [
        QueryStructure::Select->name  => 'SELECT * FROM `{TABLE}` WHERE {ARGUMENTS};',        
        QueryStructure::SelectSpecific->name  => 'SELECT {VALUES_ARGUMENTS} FROM `{TABLE}` WHERE {ARGUMENTS};',        
        QueryStructure::SelectAll->name  => 'SELECT * FROM `{TABLE}`;',        
        QueryStructure::SelectAll->name  => ';',        
        QueryStructure::Update->name  => 'UPDATE `{TABLE}` SET {ARGUMENTS} WHERE {ID};',        
        QueryStructure::Insert->name  => 'INSERT INTO `{TABLE}` {ARGUMENTS};',        
        QueryStructure::Delete->name  => 'DELETE FROM `{TABLE}` WHERE {ARGUMENTS};',        

        QueryStructure::CreateTable->name  => 'CREATE TABLE `{DATABSE}`.`{TABLE}` ({KEYS});',        
        QueryStructure::CreateKey->name  => 'ALTER TABLE `{TABLE}` ADD {KEYS};',        
        QueryStructure::UpdateKey->name  => 'ALTER TABLE `{TABLE}` CHANGE {KEY} {KEYS};',        
        QueryStructure::DeleteKey->name  => 'ALTER TABLE `{TABLE}` DROP {KEYS};',        
     
    ];

}

?>