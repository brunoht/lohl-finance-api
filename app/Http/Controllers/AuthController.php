<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function authenticate(Request $request) : JsonResponse
    {
        $cpf = $request->get('cpf');

        if (!$cpf) return $this->response(code: 404);

        $response = $this->authService->authenticate($cpf);

        return $this->responseData($response);
    }
}
