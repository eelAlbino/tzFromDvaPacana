<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Swagger\Models\IPaymentStatusSwagger;

class PaymentStatus extends Model implements IPaymentStatusSwagger
{
    use HasFactory;
}
