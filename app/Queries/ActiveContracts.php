<?php

namespace App\Queries;

use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ActiveContracts extends Query
{
    protected function query() : Builder
    {
        return Contract::whereNull('finished_at')
            ->orWhereBetween('finished_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ]);
    }
}
