<?php

namespace DisciteDB\Config\Default;

use DisciteDB\Config\Enums\TypeString;
use DisciteDB\Config\Enums\TypeDate;
use DisciteDB\Config\Enums\TypeFloat;
use DisciteDB\Config\Enums\TypeInteger;
use DisciteDB\Config\Enums\TypeBinary;

class TypeConfig
{
    
    public static array $LENGTH_MAP = 
    [
        TypeString::SmallText->name  => 100,        
        TypeString::String->name     => 255,        
        TypeString::MediumText->name => 16777215,   
        TypeString::LongText->name   => 4294967295, 
        TypeString::UUID->name       => 36,         
        TypeString::Email->name      => 320,        
        TypeString::URL->name        => 2083,       
        TypeString::IP->name         => 45,         
        TypeString::Username->name   => 50,         
        TypeString::Password->name   => 255,        

        TypeInteger::TinyInt->name   => 3,          
        TypeInteger::SmallInt->name  => 5,          
        TypeInteger::MediumInt->name => 8,          
        TypeInteger::Integer->name   => 10,         
        TypeInteger::BigInt->name    => 20,         
        TypeInteger::Boolean->name   => 1,          
        TypeInteger::UnixTime->name  => 10,         

        TypeFloat::Float->name       => [10, 2],
        TypeFloat::Double->name      => [16, 4],
        TypeFloat::Decimal->name     => [10, 2],     

        TypeDate::Date->name         => 0,          
        TypeDate::Time->name         => 0,
        TypeDate::DateTime->name     => 0,
        TypeDate::Timestamp->name    => 0,
        TypeDate::Year->name         => 4,

        TypeBinary::Blob->name       => 65535,      
        TypeBinary::TinyBlob->name   => 255,        
        TypeBinary::MediumBlob->name => 16777215,   
        TypeBinary::LongBlob->name   => 4294967295, 
        TypeBinary::Json->name       => 65535,      
        TypeBinary::File->name       => 65535,      
    ];

}

?>