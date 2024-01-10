<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;

class FetchPaymentByBillingId extends Action
{
    use HasActionSet;

    private $id;

    protected function setParams($params = []): void
    {
        $this->id = $params['id'];
    }

    protected function handle() : Payment|null
    {
        return Payment::where('billing_id', $this->id)->first();
    }

}
