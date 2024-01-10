<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birthdate',
        'phone',
        'whatsapp',
        'email',
        'address',
        'address_number',
        'address_complement',
        'address_neighborhood',
        'address_postcode',
        'address_city',
        'address_state',
        'address_country',
        'notification_email',
        'notification_whatsapp',
    ];

    public function firstName()
    {
        $nameParts = explode(" ", $this->name);
        return $nameParts[0];
    }

    public function lastName()
    {
        $nameParts = explode(" ", $this->name);
        return array_slice($nameParts, -1)[0];
    }
}
