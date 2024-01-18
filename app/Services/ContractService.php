<?php

namespace App\Services;

use App\Models\Customer;
use App\Traits\HasContractActions;
use Tymon\JWTAuth\Claims\Custom;

class ContractService extends Service
{
    use HasContractActions;

    public function fetch(Customer $customer) : array
    {
        $contracts = $this->contractsByCustomerId($customer->id);

        return $this->response(data: $contracts);
    }
}
