<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Billing;
use App\Traits\HasActionSet;
use App\Traits\HasContractActions;

class FetchPayedBillingsByCustomerId extends Action
{
    use HasActionSet;
    use HasContractActions;

    private int $customerId;

    protected function setParams($params = []): void
    {
        $this->customerId = $params['customerId'];
    }

    protected function handle()
    {
        $contractIds = $this->contractIdsByCustomerId($this->customerId);

        return Billing::whereIn('contract_id', $contractIds)
            ->with(['contract', 'contract.product', 'items', 'payment'])
            ->whereRelation('payment', 'status', 'success')
            ->get();
    }
}
