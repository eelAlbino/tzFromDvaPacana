<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Swagger\Models\IPaymentGatewaySwagger;

class PaymentGateway extends Model implements IPaymentGatewaySwagger
{
    use HasFactory;
}
