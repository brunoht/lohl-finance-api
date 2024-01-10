<?php

namespace App\Traits;

use App\Actions\MercadoPago\MPCreatePayment;
use App\Actions\MercadoPago\MPFetchPayment;
use App\Models\Payment;

trait HasMercadoPagoActions
{
    protected function createPaymentOnMercadoPago(Payment $payment) : array|null
    {
        return MPCreatePayment::set([
            'payment' => $payment
        ])->run();
    }

    protected function paymentFromMercadoPago(Payment $payment): array|null
    {
        return MPFetchPayment::set([
            'payment' => $payment
        ])->run();
    }
}
