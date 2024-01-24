<?php

namespace App\Services;

use App\Models\Payment;
use App\Traits\HasBillingActions;
use App\Traits\HasMercadoPagoActions;
use App\Traits\HasPaymentActions;
use Carbon\Carbon;

class PaymentService extends Service
{
    use HasPaymentActions, HasBillingActions, HasMercadoPagoActions;

    public function post( string $billingUuid ) : array
    {
        if ( !$billing = $this->billingByUuid($billingUuid) ) // check if Billing exists
            return $this->response(code: 404, message: 'billing not found');

        $billingId = $billing->id; // gets Billing's ID

        $payment = $this->paymentByBillingId($billingId);

        if ( !$payment || $payment->mercadopago_payment_id === null ) // check if Payment exists
        {
            $payment = $this->createPayment($billing);

            $data = $this->createPaymentOnMercadoPago($payment);

            $payment = $this->updatePayment($payment, Payment::mercadopagoBind($data));

            return $this->response(data: $payment);
        }

        elseif ($payment->status === 'approved') { // Payment exists and it is already paid
            return $this->response(data: $payment);
        }

        else // Payment exists but it is not paid
        {
            if ($payment->status === 'pending')
            {
                $data = $this->paymentFromMercadoPago($payment); // fetches MercadoPagos's Payment data

                $expiration = Carbon::make($data['date_of_expiration']);
                $now = Carbon::now()->setTimezone('-04:00');

                if ($data['status'] !== 'approved' && $now->diffInSeconds($expiration) <= 0)
                {
                    $data = $this->createPaymentOnMercadoPago($payment);
                }

                $payment = $this->updatePayment($payment, Payment::mercadopagoBind($data));

                return $this->response(data: $payment);
            }
        }

        return $this->response(data: $payment);
    }
}
