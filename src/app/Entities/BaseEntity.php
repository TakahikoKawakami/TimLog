<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Support\Str;

class BaseEntity
{
    public function toArray(): array
    {
        $result = [];
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function bulkUpdateByArray(array $array): void
    {
        foreach ($array as $key => $value) {
            if ($this->has($key)) {
                // Str::studly 頭文字を大文字に変換する（pascal case）
                $methodName = "update" . Str::studly($key);
                $this->$methodName($value);
            }
        }
    }

    public function has($key)
    {
        $thisArray = $this->toArray();
        return isset($thisArray[$key]) ? true : false;
    }
}
