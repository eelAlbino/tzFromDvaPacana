<?php

namespace App\PaymentGateways\TestFirst;

use App\Models\Payment;
use App\Models\PaymentGateway;
use App\PaymentGateways\BaseCallback;
use Exception;
use Illuminate\Support\Facades\Http;

class Callback extends BaseCallback
{
   /**
    * ID мерчанта
    */
    private int $merchantID;
    /**
     * Ключ мерчанта
     */
    private string $merchantKey;

    function __construct(PaymentGateway $gateway) {
        parent::__construct($gateway);
        $this->setAuthParams();
    }

    /**
     * Параметры для аутентификации
     * @throws Exception
     */
    private function setAuthParams() {
        $merchantID = (int) env('PAYMENT_GATEWAY_FIRST_MERCHANT_ID');
        if (!$merchantID) {
            throw new Exception('Отсутствует env параметр PAYMENT_GATEWAY_FIRST_MERCHANT_ID');
        }
        $this->merchantID = $merchantID;
        $merchantKey = (string) env('PAYMENT_GATEWAY_FIRST_MERCHANT_KEY');
        if (!$merchantID) {
            throw new Exception('Отсутствует env параметр PAYMENT_GATEWAY_FIRST_MERCHANT_ID');
        }
        $this->merchantKey = $merchantKey;
    }

    /**
     * Отправка данных элемента оплаты при его обновлении на первый шлюз
     * @param Payment $payment
     * @throws Exception
     * @return bool
     */
    protected function processSendUpdatedPayment(Payment $payment): bool
    {
        $status = $this->status($payment);
        if (!$status) {
            throw new Exception('Для оплаты '.$payment->id.' не может быть определен внешний статус');
        }
        $url = $this->gateway->callback_url;
        if (!$url) {
            throw new Exception('У элемента шлюза не заполнен параметр callback_url');
        }
        $jsonData = [
            'merchant_id' => $this->merchantID,
            'payment_id' => (int) $payment->guid,
            'status' => $status,
            'amount' => $payment->amount,
            'amount_paid' => $payment->amount_paid,
            'timestamp' => time()
        ];
        $jsonData['sign'] = $this->sign($jsonData);
        // Отправка данных POST методом (в задаче не было указано, каким именно слать)
        $response = Http::post($url, [], ['json' => $jsonData]);
        // Получение тела ответа (опять же, в задаче не указано, что мы должны получить)
        $responseBody = $response->body();
        return true;
    }

    /**
     * Получение внешнего статуса из текущих параметров элемента оплаты
     * @param Payment $payment
     */
    private function status(Payment $payment): ?string
    {
        $statusAliases = [
            'created' => 'new',
            'pending' => 'pending',
            'completed' => 'completed',
            'expired' => 'expired',
            'rejected' => 'rejected'
        ];
        return $statusAliases[ $payment->status ] ?? null;
    }

    /**
     * Правила формирования подписи:
     * 1. Отсортировать параметры по алфавиту.
     * 2. Объединить их (за исключением sign), используя разделитель :.
     * 3. К концу получившейся строки добавить merchant_key.
     * 4. Получить из неё SHA256 хеш.
     * @param array $jsonData
     * @return string
     */
    private function sign(array $jsonData): string
    {
        $result = null;
        ksort($jsonData);
        $result = implode(':', $jsonData);
        $result .= $this->merchantKey;
        $result = hash('sha256', $result);
        return $result;
    }
}