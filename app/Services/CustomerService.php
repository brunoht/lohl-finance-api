<?php

namespace App\Services;

use App\Models\User;
use App\Traits\HasCustomerActions;

class CustomerService extends Service
{
    use HasCustomerActions;

    public function fetch(User $user) : array
    {
        return $this->response(data: $user);
    }
}
