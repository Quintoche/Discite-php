<?php

namespace DisciteDB\Utilities;


class ValidateJson
{


    public static function validate(string $json): bool
    {
        if(!str_contains($json, '{')) return false;
        if(!str_contains($json, '}')) return false;

        if(!is_object(json_decode($json,true))) return false;

        return true;
    }

    public static function isJson(string $string): bool {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
?>