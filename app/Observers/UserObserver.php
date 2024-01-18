<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        Customer::create([
            'user_id' => $user->id
        ]);
    }
}
