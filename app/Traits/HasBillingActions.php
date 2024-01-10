<?php

namespace App\Traits;

use App\Actions\Api\FetchBilling;
use App\Actions\Api\FetchBillingsByCustomerId;
use App\Actions\Api\FetchExpiredBillingsByCustomerId;
use App\Actions\Api\FetchPayedBillingsByCustomerId;
use App\Actions\Api\FetchPendingBillingsByCustomerId;
use App\Models\Billing;
use Illuminate\Database\Eloquent\Collection;

trait HasBillingActions
{
    protected function billingByUuid(string $billingUuid) : Billing|null
    {
        return FetchBilling::set([
            'uuid' => $billingUuid
        ])->run();
    }

    protected function billingsByCustomerId(int $customerId) : Collection
    {
        return FetchBillingsByCustomerId::set([
            'customerId' => $customerId
        ])->run();
    }

    protected function pendingBillingsByCustomerId(int $customerId)
    {
        return FetchPendingBillingsByCustomerId::set([
            'customerId' => $customerId
        ])->run();
    }

    protected function expiredBillingsByCustomerId(int $customerId)
    {
        return FetchExpiredBillingsByCustomerId::set([
            'customerId' => $customerId
        ])->run();
    }

    protected function payedBillingsByCustomerId(int $customerId)
    {
        return FetchPayedBillingsByCustomerId::set([
            'customerId' => $customerId
        ])->run();
    }
}
