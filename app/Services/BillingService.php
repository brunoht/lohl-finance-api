<?php

namespace App\Services;

use App\Models\Customer;
use App\Traits\HasBillingActions;

class BillingService extends Service
{
    use HasBillingActions;

    public function open(Customer $customer) : array
    {
        $billings = $this->billingsByCustomerId($customer->id);
        return $this->response(data: $billings);
    }

    public function pending(Customer $customer) : array
    {
        $billings = $this->pendingBillingsByCustomerId($customer->id);
        return $this->response(data: $billings);
    }

    public function payed(Customer $customer) : array
    {
        $billings = $this->payedBillingsByCustomerId($customer->id);
        return $this->response(data: $billings);
    }

    public function expired(Customer $customer) : array
    {
        $billings = $this->expiredBillingsByCustomerId($customer->id);
        return $this->response(data: $billings);
    }
}
