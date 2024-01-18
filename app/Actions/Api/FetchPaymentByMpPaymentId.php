<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;

class FetchPaymentByMpPaymentId extends Action
{
    use HasActionSet;

    private string $mercadopagoPaymentId;

    protected function setParams($params = []): void
    {
        $this->mercadopagoPaymentId = $params['mercadopagoPaymentId'];
    }

    protected function handle() : Payment|null
    {
        return Payment::where('mercadopago_payment_id', $this->mercadopagoPaymentId)->with(['billing'])->first();
    }
}
