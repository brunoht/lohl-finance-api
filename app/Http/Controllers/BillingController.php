<?php

namespace App\Http\Controllers;

use App\Services\BillingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    private BillingService $billingService;

    public function __construct()
    {
        $this->billingService = new BillingService();
    }

    public function open(Request $request) : JsonResponse
    {
        $customerId = $request->get('customer_id');

        if (!$customerId) return $this->response(code: 401);

        $response = $this->billingService->open($customerId);

        return $this->responseData($response);
    }

    public function pending(Request $request) : JsonResponse
    {
        $customerId = $request->get('customer_id');

        if (!$customerId) return $this->response(code: 401);

        $response = $this->billingService->pending($customerId);

        return $this->responseData($response);
    }

    public function payed(Request $request) : JsonResponse
    {
        $customerId = $request->get('customer_id');

        if (!$customerId) return $this->response(code: 401);

        $response = $this->billingService->payed($customerId);

        return $this->responseData($response);
    }

    public function expired(Request $request) : JsonResponse
    {
        $customerId = $request->get('customer_id');

        if (!$customerId) return $this->response(code: 401);

        $response = $this->billingService->expired($customerId);

        return $this->responseData($response);
    }
}
