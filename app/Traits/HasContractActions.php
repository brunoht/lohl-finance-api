<?php

namespace App\Traits;

use App\Actions\Api\FetchContractIds;
use App\Actions\Api\FetchContracts;
use Illuminate\Database\Eloquent\Collection;

trait HasContractActions
{
    protected function contractsByCustomerId(int $customerId) : Collection|null
    {
        return FetchContracts::set([
            'customerId' => $customerId
        ])->run();
    }

    protected function contractIdsByCustomerId(int $customerId)
    {
        return FetchContractIds::set([
            'customerId' => $customerId
        ])->run();
    }
}
