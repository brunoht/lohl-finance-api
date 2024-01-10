<?php

namespace App\Actions\Api;

use App\Actions\Action;
use App\Models\Customer;
use App\Traits\HasActionSet;

class FetchCustomerByCpf extends Action
{
    use HasActionSet;

    private string $cpf;

    protected function setParams($params = []): void
    {
        $this->cpf = $params['cpf'];
    }

    protected function handle() : Customer
    {
        return Customer::where('cpf', $this->cpf)->first();
    }
}
