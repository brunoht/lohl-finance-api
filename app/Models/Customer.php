<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birthdate',
        'phone_01',
        'phone_02',
        'address',
        'address_number',
        'address_complement',
        'address_neighborhood',
        'address_postcode',
        'address_city',
        'address_state',
        'address_country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
