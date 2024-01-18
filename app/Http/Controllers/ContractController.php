<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ContractService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    private ContractService $contractService;

    public function __construct()
    {
        $this->contractService = new ContractService();
    }

    public function fetch(Request $request) : JsonResponse
    {
        $user = auth()->user()->load('customer');

        $response = $this->contractService->fetch($user->customer);

        return $this->responseData($response);
    }
}
