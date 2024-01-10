<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function post(Request $request, PaymentService $service) : JsonResponse
    {
        $billingUuid = $request->get('billing_uuid');

        if (!$billingUuid) return $this->response(code: 401);

        $response = $service->post($billingUuid);

        return $this->responseData($response);
    }
}
