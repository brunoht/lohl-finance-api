<?php

namespace App\Models;

use App\Utils\Math;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'description',
        'contract_id',
        'price',
        'expire_at',
        'installment',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'billing_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(BillingItem::class, 'billing_id', 'id');
    }

    public function amount() : float
    {
        $amount = 0;
        foreach ($this->items as $item) {
            $amount += $item->price * $item->qty;
        }
        return $amount;
    }

    public function fees() : float
    {
        return Math::calculateFees($this->amount(), $this->expire_at);
    }

    public function total() : float
    {
        return $this->amount() + $this->fees();
    }
}
