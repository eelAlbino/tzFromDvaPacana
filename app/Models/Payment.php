<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Swagger\Models\IPaymentSwagger;

class Payment extends Model implements IPaymentSwagger
{
    use HasFactory;

}
