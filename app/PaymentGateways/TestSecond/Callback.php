<?php

namespace App\PaymentGateways\TestSecond;

use App\Models\Payment;
use App\Models\PaymentGateway;
use App\PaymentGateways\BaseCallback;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Callback extends BaseCallback
{

    /**
     * ID приложения
     */
    private int $appID;
    /**
     * Ключ приложения
     */
    private string $appKey;
    
    function __construct(PaymentGateway $gateway) {
        parent::__construct($gateway);
        $this->setAuthParams();
    }

    /**
     * Параметры для аутентификации
     * @throws Exception
     */
    private function setAuthParams() {
        $appID = (int) env('PAYMENT_GATEWAY_SECOND_APP_ID');
        if (!$appID) {
            throw new Exception('Отсутствует env параметр PAYMENT_GATEWAY_SECOND_APP_ID');
        }
        $this->appID = $appID;
        $appKey = (string) env('PAYMENT_GATEWAY_SECOND_APP_KEY');
        if (!$appKey) {
            throw new Exception('Отсутствует env параметр PAYMENT_GATEWAY_SECOND_APP_KEY');
        }
        $this->appKey = $appKey;
    }

    /**
     * Отправка данных элемента оплаты при его обновлении на второй шлюз
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
        $postData = [
            'project' => $this->appID,
            'invoice' => (int) $payment->guid,
            'status' => $status,
            'amount' => $payment->amount,
            'amount_paid' => $payment->amount_paid,
            'rand' => Str::random(10)
        ];
        $headers = [
            'Authorization' => $this->authToken($postData)
        ];
        // Отправка данных POST методом (в задаче не было указано, каким именно слать)
        $response = Http::withHeaders($headers)->post($url, $postData);
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
            'created' => 'created',
            'pending' => 'inprogress',
            'completed' => 'paid',
            'expired' => 'expired',
            'rejected' => 'rejected'
        ];
        return $statusAliases[ $payment->status ] ?? null;
    }

    /**
     * Правила формирования подписи:
     * 1. Отсортировать параметры по алфавиту.
     * 2. Объединить поля, используя разделитель ".".
     * 2. К концу получившейся строки добавить app_key.
     * 2. Получить из неё MD5 хеш.
     * @param array $postData
     * @return string
     */
    private function authToken(array $postData): string
    {
        $result = null;
        ksort($postData);
        $result = implode('.', $postData);
        $result .= $this->appKey;
        $result = hash('md5', $result);
        return $result;
    }
}