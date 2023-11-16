<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Exception;

/**
 * Отправка данных по оплате на шлюз в момент обновления элемента оплаты
 *
 */
class SendUpdatedPaymentToGatewayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ID элемента оплаты
     * @var unknown
     */
    private int $paymentID;
    /**
     * Create a new job instance.
     */
    public function __construct(int $paymentID)
    {
        $this->paymentID = $paymentID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payment = $this->payment($this->paymentID);
        if (!$payment) {
            throw new Exception('Элемент оплаты с id '. $this->paymentID .' не найден');
        }
        $paymentGateway = $payment->gateway()->first();
        if (!$paymentGateway) {
            throw new Exception('Для оплаты с id '. $this->paymentID .' не найден элемент шлюза');
        }
        // @todo: Вызов обработчика отправки
    }

    /**
     * Получение элемента оплаты по ID
     * @param int $id
     * @return Payment|NULL
     */
    private function payment(int $id): ?Payment
    {
        return Payment::find($id);
    }
}
