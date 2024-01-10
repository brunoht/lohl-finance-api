<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Payment;
use App\Traits\HasActionSet;

/**
 * Update Payment
 */
class UpdatePayment extends Action
{
    use HasActionSet;

    private Payment $payment;
    private array $data;

    protected function setParams($params = []): void
    {
        $this->payment = $params['payment'];
        $this->data = $params['data'];
    }

    protected function handle() : Payment
    {
        $result = $this->payment->updateData( $this->data );
        return $result
            ? Payment::where('id', $this->payment->id)->first()
            : $this->payment;
    }
}
