<?php

namespace App\PaymentGateways;

use App\Models\Payment;
use App\Models\PaymentGateway;

abstract class BaseCallback
{
    /**
     * Элемент модели шлюза
     */
    protected PaymentGateway $gateway;

    function __construct(PaymentGateway $gateway) {
        $this->gateway = $gateway;
    }

    /**
     * Отправка данных элемента оплаты при его обновлении.
     * @param Payment $payment
     * @return bool
     */
    abstract protected function processSendUpdatedPayment(Payment $payment): bool;

    /**
     * Отправка обновленного элемента оплаты.
     * Происходит проверка дневного лимита отправки, если у шлюза установлено соответствующее ограничение.
     * @param Payment $payment
     */
    public function sendUpdatedPayment(Payment $payment) {
        // check limit (daily count)
        $this->processSendUpdatedPayment($payment);
        // inc daily count
    }

}