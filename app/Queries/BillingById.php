<?php

namespace App\Queries;

use App\Models\Billing;
use Illuminate\Database\Eloquent\Builder;

class BillingById extends Query
{
    protected function query() : Builder
    {
        return Billing::where($this->params)
            ->with([
                'items',
                'contract',
                'contract.product',
                'contract.customer',
                'contract.customer.user'
            ]);
    }
}
