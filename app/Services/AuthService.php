<?php

namespace App\Services;

use App\Traits\HasCustomerActions;

class AuthService extends Service
{
    use HasCustomerActions;

    public function authenticate($cpf) : array
    {
        if ($customer = $this->customerByCpf($cpf))
        {
            return $this->response(data: [
                'authorized' => true,
                'customer_id' => $customer->id
            ]);
        }
        return $this->response(code: 404);
    }
}
