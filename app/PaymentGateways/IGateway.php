<?php

namespace App\PaymentGateways;

use App\Models\Payment;
use App\Models\PaymentGateway;

interface IGateway
{
    /**
     * Получение объекта колбека для взаимодействия с заданным шлюзом
     * @return BaseCallback
     */
    public function callback(PaymentGateway $modelElem): BaseCallback;
}