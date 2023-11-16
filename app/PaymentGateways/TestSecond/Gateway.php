<?php

namespace App\PaymentGateways\TestSecond;

use App\PaymentGateways\IGateway;
use App\PaymentGateways\BaseCallback;
use App\Models\PaymentGateway;

class Gateway implements IGateway
{
    public function callback(PaymentGateway $modelElem): BaseCallback
    {
        return new Callback($modelElem);
    }
}