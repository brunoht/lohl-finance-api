<?php

namespace App\Traits;

use App\Actions\Api\FetchCustomerByCpf;
use App\Actions\Api\FetchCustomerById;
use App\Models\Customer;

trait HasCustomerActions
{
    protected function customer(int $id)
    {
        return FetchCustomerById::set([
            'id' => $id
        ])->run();
    }
    protected function customerByCpf(string $cpf) : Customer
    {
        return FetchCustomerByCpf::set([
            'cpf' => $cpf
        ])->run();
    }
}
