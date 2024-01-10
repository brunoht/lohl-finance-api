<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Contract;
use App\Traits\HasActionSet;
use Illuminate\Database\Eloquent\Collection;

class FetchContracts extends Action
{
    use HasActionSet;

    private int $customerId;

    protected function setParams($params = []): void
    {
        $this->customerId = $params['customerId'];
    }

    protected function handle() : Collection
    {
        return Contract::where('customer_id', $this->customerId)->with(['product'])->get();
    }
}
