<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function index() : JsonResponse
    {
        return response()->json(['status' => 'working']);
    }

    public function unauthorized() : JsonResponse
    {
        return $this->response(code: 401);
    }

    public function debug(Request $request)
    {
        Log::info("X-Idempotency-Key: " . $request->header('X-Idempotency-Key'));
        return response()->json($request->hasHeader('X-Idempotency-Key'));
    }
}
