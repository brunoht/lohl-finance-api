<?php

namespace App\Http\Controllers;

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
        $customerId = $request->get('customer_id');

        if (!$customerId) return $this->response(code: 401);

        $response = $this->contractService->fetch($customerId);

        return $this->responseData($response);
    }
}
