<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function fetch() : JsonResponse
    {
        $user = auth()->user()->load('customer');
        $response = $this->customerService->fetch($user);
        return $this->responseData($response);
    }
}
