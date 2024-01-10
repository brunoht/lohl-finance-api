<?php

namespace App\Services;

use App\Traits\HasContractActions;

class ContractService extends Service
{
    use HasContractActions;

    public function fetch($customerId) : array
    {
        $contracts = $this->contractsByCustomerId($customerId);

        return $this->response(data: $contracts);
    }
}
