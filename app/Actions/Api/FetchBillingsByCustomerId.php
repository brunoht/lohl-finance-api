<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Billing;
use App\Traits\HasActionSet;
use App\Traits\HasContractActions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class FetchBillingsByCustomerId extends Action
{
    use HasActionSet;
    use HasContractActions;

    private int $customerId;

    protected function setParams($params = []): void
    {
        $this->customerId = $params['customerId'];
    }

    protected function handle() : Collection
    {
        $contractIds = $this->contractIdsByCustomerId($this->customerId);

        return Billing::whereIn('contract_id', $contractIds)
            ->with(['contract', 'contract.product', 'items', 'payment'])
            ->whereDate('expire_at', '<=', Carbon::now()->endOfMonth())
            ->doesntHave('payment')
            ->orWhereRelation('payment', 'status', 'pending')
            ->get();
    }
}
