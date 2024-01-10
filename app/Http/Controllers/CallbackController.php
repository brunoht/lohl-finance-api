<?php

namespace App\Http\Controllers;

use App\Services\CallbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    private CallbackService $callbackService;

    public function __construct()
    {
        $this->callbackService = new CallbackService();
    }

    public function mercadopago(Request $request) : JsonResponse
    {
        try
        {
            $data = $request->all();

            $response = $this->callbackService->mercadopago(
                signature: $request->header('X-Signature-Id'),
                action: $data['action'],
                type: $data['type'],
                mercadopagoPaymentId: $data['data']['id']
            );

            if ($response['status_code'] !== 200)
            {
                Log::info($request->headers);
                Log::info(json_encode($request->all()));
            }

            Log::info(json_encode($response));

            return $this->responseData($response);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return $this->response();
        }
    }
}
