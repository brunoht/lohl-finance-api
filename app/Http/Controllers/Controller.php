<?php

namespace App\Http\Controllers;

use App\Traits\HasStatusCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HasStatusCode;

    protected function response($code = 200, $data = [], $message = "") : JsonResponse
    {
        return response()->json([
            'status' => self::$statusCode[$code],
            'status_code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function responseData($response)
    {
        return response()->json($response, $response['status_code']);
    }
}
