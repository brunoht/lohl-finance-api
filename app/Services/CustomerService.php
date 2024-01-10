<?php

namespace App\Services;

use App\Traits\HasCustomerActions;

class CustomerService extends Service
{
    use HasCustomerActions;

    public function fetch(int $id) : array
    {
        $customer = $this->customer($id);
        if ($customer) return $this->response(data: $customer);
        return $this->response(404);
    }
}
