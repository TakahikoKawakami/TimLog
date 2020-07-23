<?php

namespace App\Utils;

use Illuminate\Support\Str;

class ArrayUtil
{
    public static function toCamelKeys(array $array)
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $results[Str::camel($key)] = self::toCamelKeys($value);
            } else {
                $results[Str::camel($key)] = $value;
            }
        }
        return $results;
    }

    public static function toSnakeKeys(array $array)
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $results[Str::snake($key)] = self::toSnakeKeys($value);
            } else {
                $results[Str::snake($key)] = $value;
            }
        }
        return $results;
    }
}
