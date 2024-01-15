<?php

namespace App\Services;

use App\Models\Payment;
use App\Traits\HasMercadoPagoActions;
use App\Traits\HasPaymentActions;

class CallbackService extends Service
{
    use HasPaymentActions, HasMercadoPagoActions;

    private string $signature;

    public function __construct()
    {
        $this->signature = env('MERCADOPAGO_WEBHOOK_SIGNATURE');
    }

    public function mercadopago (string|null $signature, string $action, string $type, string $mercadopagoPaymentId) : array
    {
//        if ($this->signature !== $signature)
//            return $this->response(code: 401, message: 'Request not verified');

        if ($type === 'payment' && $action === "payment.update")
        {
            $payment = $this->paymentByMpPaymentId($mercadopagoPaymentId);

            if ($payment)
            {
                $data = $this->paymentFromMercadoPago($payment);

                $this->updatePayment($payment, Payment::mercadopagoBind($data));
            }
            else
            {
                return $this->response(code: 404, data: [
                    'type' => $type,
                    'action' => $action,
                    'id' => $mercadopagoPaymentId
                ], message: 'Payment not found');
            }
        }

        return $this->response(data: [
            'type' => $type,
            'action' => $action,
            'id' => $mercadopagoPaymentId,
        ]);
    }
}
