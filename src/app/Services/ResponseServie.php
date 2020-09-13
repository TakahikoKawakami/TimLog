<?php

namespace App\Services;
use Carbon\Carbon;
use App\Utils\ArrayUtil;
use Illuminate\Http\JsonResponse;

class ResponseService
{
    public function makeResponse(array $array): JsonResponse
    {
        $snakeKeyArray = ArrayUtil::toSnakeKeys($array);
        $stringArray = ArrayUtil::toStringValues($array);
        return response()->json($stringArray);
    }
}
