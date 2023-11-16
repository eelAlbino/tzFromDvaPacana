<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Exception;
use Throwable;

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
        try {
            if (!$payment) {
                throw new Exception('Элемент оплаты с id '. $this->paymentID .' не найден');
            }
            $paymentGateway = $payment->gateway()->first();
            if (!$paymentGateway) {
                throw new Exception('Для оплаты с id '. $this->paymentID .' не найден элемент шлюза');
            }
            $gatewayService = app('payment_gateway_'. $paymentGateway->code);
            if (!$gatewayService) {
                throw new Exception('Объект класса для работы с шлюзом оплаты '. $paymentGateway->code .' не найден');
            }
            $gatewayService->callback($paymentGateway)->sendUpdatedPayment($payment);
        } catch (Throwable $e) {
            // Тут в принципе ничего не было сказано по поводу обработки ошибки.
            // Для примера добавил лог
            Log::channel('payment_gateway_send_payment_on_update')->error($e->getMessage());
        }
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
