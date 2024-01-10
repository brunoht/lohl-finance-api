<?php

namespace App\Models;

use App\Utils\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'customer_id',
        'billing_expire_at',
        'amount',
        'fees',
        'transaction_amount',
        'description',
        'payment_method_id',
        'date_of_expiration',
        'payer_email',
        'payer_first_name',
        'payer_last_name',
        'payer_identification_type',
        'payer_identification_number',
        'status',
        'date_approved',
        'mercadopago_payment_id',
        'mercadopago_qr_code',
        'mercadopago_qr_code_base64',
        'mercadopago_ticket_url',
    ];

    public static function bind(Billing $billing) : array
    {
        return [
            'billing_id' => $billing->id,
            'contract_id' => $billing->contract->id,
            'customer_id' => $billing->contract->customer->id,
            'amount' => $billing->amount(),
            'fees' => $billing->fees(),
            'transaction_amount' => $billing->total(),
            'description' => $billing->description,
            'payment_method_id' => "pix",
            'date_of_expiration' => Date::addMinutes(minutes: 5, format: Date::$MERCADOPAGO_DATE_FORMAT),
            'payer_email' => $billing->contract->customer->email,
            'payer_first_name' => $billing->contract->customer->firstName(),
            'payer_last_name' => $billing->contract->customer->lastName(),
            'payer_identification_type' => 'CPF',
            'payer_identification_number' => $billing->contract->customer->cpf,
            'billing_expire_at' => $billing->expire_at
        ];
    }

    public static function mercadopagoBind(array $mercadopagoPayment) : array
    {
        return [
            'mercadopago_payment_id' => $mercadopagoPayment['id'],
            'mercadopago_qr_code' => $mercadopagoPayment['point_of_interaction']['transaction_data']['qr_code'],
            'mercadopago_qr_code_base64' => $mercadopagoPayment['point_of_interaction']['transaction_data']['qr_code_base64'],
            'mercadopago_ticket_url' => $mercadopagoPayment['point_of_interaction']['transaction_data']['ticket_url'],
            'status' => $mercadopagoPayment['status'],
            'date_approved' => $mercadopagoPayment['date_approved'],
        ];
    }

    public function updateData($data)
    {
        $this->update($data);
        return self::where('id', $this->id)->first();
    }
}
