<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Swagger\Models\IPaymentSwagger;
use App\Events\PaymentUpdated;

class Payment extends Model implements IPaymentSwagger
{
    use HasFactory;

    /**
     * Шлюз оплаты
     */
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }

    /**
     * Покупатель
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    protected $dispatchesEvents = [
        'updated' => PaymentUpdated::class,
    ];
}
