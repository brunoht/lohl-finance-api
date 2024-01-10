<?php

namespace App\Services;

use App\Models\Payment;
use App\Traits\HasBillingActions;
use App\Traits\HasMercadoPagoActions;
use App\Traits\HasPaymentActions;
use App\Utils\Date;

class PaymentService extends Service
{
    use HasPaymentActions, HasBillingActions, HasMercadoPagoActions;

    public function post( string $billingUuid ) : array
    {
        if ( !$billing = $this->billingByUuid($billingUuid) ) // check if Billing exists
            return $this->response(code: 404, message: 'billing not found');

        $billingId = $billing->id; // gets Billing's ID

        if ( !$payment = $this->paymentByBillingId($billingId) ) // check if Payment exists
        {
            $payment = $this->createPayment($billing);

            $data = $this->createPaymentOnMercadoPago($payment);
        }

        elseif ( // Payment exists, but QrCode expired and it needs refreshing
            $payment->mercadopago_payment_id === null
            || Date::diff($payment->date_of_expiration ) <= 0
        ) {
            $payment = $this->updatePayment($payment, Payment::bind($billing));

            $data = $this->createPaymentOnMercadoPago($payment);
        }

        else // Payment exists and valid QrCode
        {
            if ($payment->status === 'pending')
            {
                $data = $this->paymentFromMercadoPago($payment); // fetches MercadoPagos's Payment data
            }
            else // if Payment is finished, it only returns data
            {
                return $this->response(data: $payment);
            }
        }

        // refreshes Payment using MercadoPagos's data
        $payment = $this->updatePayment($payment, Payment::mercadopagoBind($data));

        return $this->response(data: $payment);
    }
}
