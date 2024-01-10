<?php

namespace App\Services;

use App\Traits\HasStatusCode;

class Service
{
    use HasStatusCode;

    public function response($code = 200, $data = [], $message = "") : array
    {
        return [
            'status' => self::$statusCode[$code],
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}
