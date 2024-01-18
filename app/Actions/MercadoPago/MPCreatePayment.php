<?php

namespace App\Actions\MercadoPago;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;
use App\Helpers\MercadoPago;

/**
 * MercadoPago Create Payment
 */
class MPCreatePayment extends Action
{
    use HasActionSet;

    private MercadoPago $mercadoPago;
    private Payment $payment;

    private function __construct()
    {
        $this->mercadoPago = new MercadoPago();
    }

    protected function setParams($params = []) : void
    {
        $this->payment = $params['payment'];
    }


    protected function handle() : array|null
    {
        $response = $this->mercadoPago->post('/payments', $this->data());
        if ($response->status() === 201) return $response->json();
        return null;
    }

    private function data() : array
    {
        return [
            'external_reference' => $this->payment->id,
            'transaction_amount' => $this->payment->transaction_amount,
            'description' => $this->payment->description,
            'payment_method_id' => $this->payment->payment_method_id,
//            'date_of_expiration' => $this->payment->date_of_expiration,
            'additional_info' => [
                'payer' => [
                    'first_name' => $this->payment->payer_first_name,
                    'last_name' => $this->payment->payer_last_name,
                    'phone' => [
                        'area_code' => $this->payment->customer->phone_01 ?? $this->payment->customer->phone_02,
                        'number' => $this->payment->customer->phone_01 ?? $this->payment->customer->phone_02,
                    ],
                    'address' => [
                        'zip_code' => $this->payment->customer->address_postcode,
                        'street_name' => $this->payment->customer->address,
                        'street_number' => $this->payment->customer->address_number
                    ]
                ]
            ],
            'payer' => [
                'first_name' => $this->payment->payer_first_name,
                'last_name' => $this->payment->payer_last_name,
                "entity_type" => "individual",
                "type" => "customer",
                'email' => $this->payment->payer_email,
                'identification' => [
                    'type' => $this->payment->payer_identification_type,
                    'number' => $this->payment->payer_identification_number
                ]
            ]
        ];
    }

}
