<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Billing;
use App\Traits\HasActionSet;

class FetchBilling extends Action
{
    use HasActionSet;

    private string $uuid;

    protected function setParams($params = []): void
    {
        $this->uuid = $params['uuid'];
    }

    protected function handle() : Billing|null
    {
        return Billing::where('uuid', $this->uuid)->with(['contract', 'contract.customer'])->first();
    }
}
