<?php

namespace App\Actions\MercadoPago;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;
use App\Utils\MercadoPago;

/**
 * MercadoPago Fetch Payment
 */
class MPFetchPayment extends Action
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

    /**
     * @return array|null
     */
    protected function handle() : array|null
    {
        $response = $this->mercadoPago->get('/payments/' . $this->payment->mercadopago_payment_id);
        if ($response->status() === 200) return $response->json();
        return null;
    }
}
