<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;

/**
 * Create Payment
 */
class CreatePayment extends Action
{
    use HasActionSet;

    private array $data;

    protected function setParams($params = []): void
    {
        $this->data = $params['data'];
    }

    protected function handle() : Payment
    {
        return Payment::create($this->data);
    }
}
