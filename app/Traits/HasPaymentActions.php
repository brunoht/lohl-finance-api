<?php

namespace App\Traits;

use App\Actions\Api\CreatePayment;
use App\Actions\Api\FetchPaymentByBillingId;
use App\Actions\Api\FetchPaymentByMpPaymentId;
use App\Actions\Api\UpdatePayment;
use App\Models\Billing;
use App\Models\Payment;

trait HasPaymentActions
{
    protected function paymentByBillingId(int $billingId) : Payment|null
    {
        return FetchPaymentByBillingId::set([
            'id' => $billingId
        ])->run();
    }

    protected function paymentByMpPaymentId(string $mercadopagoPaymentId) : Payment|null
    {
        return FetchPaymentByMpPaymentId::set([
            'mercadopagoPaymentId' => $mercadopagoPaymentId
        ])->run();
    }

    protected function createPayment(Billing $billing) : Payment
    {
        return CreatePayment::set([
            'data' => Payment::bind($billing)
        ])->run();
    }

    protected function updatePayment(Payment $payment, array $data) : Payment
    {
        return UpdatePayment::set([
            'payment' => $payment,
            'data' => $data
        ])->run();
    }
}
