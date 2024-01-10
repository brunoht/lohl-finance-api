<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Customer;
use App\Traits\HasActionSet;

class FetchCustomerById extends Action
{
    use HasActionSet;

    private int $id;

    protected function setParams($params = []): void
    {
        $this->id = $params['id'];
    }

    protected function handle() : Customer|null
    {
        return Customer::where('id', $this->id)->first();
    }
}
