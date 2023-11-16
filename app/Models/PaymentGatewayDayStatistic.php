<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayDayStatistic extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_day_statistic';

    protected $fillable = [
        'date',
        'gateway_id',
        'attempts_count'
    ];

    /**
     * Шлюз оплаты
     */
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }
}
