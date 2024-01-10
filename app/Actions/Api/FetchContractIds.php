<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Contract;
use App\Traits\HasActionSet;

class FetchContractIds extends Action
{
    use HasActionSet;

    private int $customerId;

    protected function setParams($params = []): void
    {
        $this->customerId = $params['customerId'];
    }

    protected function handle()
    {
        return Contract::where('customer_id', $this->customerId)->pluck('id')->toArray();
    }
}
