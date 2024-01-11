<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user = auth()->user()->load('customer');

        $response = $this->billingService->open($user->customer);

        return $this->responseData($response);
    }

    public function pending(Request $request) : JsonResponse
    {
        $user = auth()->user()->load('customer');

        $response = $this->billingService->pending($user->customer);

        return $this->responseData($response);
    }

    public function payed(Request $request) : JsonResponse
    {
        $user = auth()->user()->load('customer');

        $response = $this->billingService->payed($user->customer);

        return $this->responseData($response);
    }

    public function expired(Request $request) : JsonResponse
    {
        $user = auth()->user()->load('customer');

        $response = $this->billingService->expired($user->customer);

        return $this->responseData($response);
    }
}
