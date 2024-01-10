<?php

namespace App\Services;

use App\Traits\HasBillingActions;

class BillingService extends Service
{
    use HasBillingActions;

    public function open($customerId) : array
    {
        $billings = $this->billingsByCustomerId($customerId);
        return $this->response(data: $billings);
    }

    public function pending($customerId) : array
    {
        $billings = $this->pendingBillingsByCustomerId($customerId);
        return $this->response(data: $billings);
    }

    public function payed($customerId) : array
    {
        $billings = $this->payedBillingsByCustomerId($customerId);
        return $this->response(data: $billings);
    }

    public function expired($customerId) : array
    {
        $billings = $this->expiredBillingsByCustomerId($customerId);
        return $this->response(data: $billings);
    }
}
