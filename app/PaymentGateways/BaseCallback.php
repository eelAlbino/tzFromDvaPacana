<?php

namespace App\PaymentGateways;

use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayDayStatistic;
use Carbon\Carbon;
use Exception;

abstract class BaseCallback
{
    /**
     * Элемент модели шлюза
     */
    protected PaymentGateway $gateway;

    /**
     * Элементы дневной статистики для текущей модели шлюза
     */
    private array $dayStatisticItems = [];

    /**
     * Проверять ли дневной лимит
     */
    private bool $useLimitDay;

    function __construct(PaymentGateway $gateway) {
        $this->gateway = $gateway;
        $this->useLimitDay = $gateway->callback_limit_day > 0;
    }

    /**
     * Отправка данных элемента оплаты при его обновлении.
     * @param Payment $payment
     * @return bool
     */
    abstract protected function processSendUpdatedPayment(Payment $payment): bool;

    /**
     * Отправка обновленного элемента оплаты.
     * Происходит проверка дневного лимита отправки, если у шлюза установлено соответствующее ограничение.
     * @param Payment $payment
     */
    public function sendUpdatedPayment(Payment $payment) {
        $dateNow = Carbon::now();
        if ($this->useLimitDay && !$this->checkLimitDay($dateNow)) {
            throw new Exception('Исчерпан лимит на дневную отправку данных');
        }
        $this->processSendUpdatedPayment($payment);
        if ($this->useLimitDay) {
            $this->incAttemptDay($dateNow);
        }
    }

    /**
     * Проверка дневного лимита на отправку данных
     * @param Carbon $date
     * @return bool
     */
    private function checkLimitDay(Carbon $date): bool
    {
        $limitDay = $this->gateway->callback_limit_day;
        if ($limitDay <= 0) {
            return true;
        }
        $statisticElem = $this->dayStatisticElem($date);
        return ($statisticElem->attempts_count < $limitDay);
    }

    /**
     * Отметка отправки данных за текущий день
     * @param Carbon $date
     */
    private function incAttemptDay(Carbon $date) {
        $statisticElem = $this->dayStatisticElem($date);
        $statisticElem->fill([
            'attempts_count' => ($statisticElem->attempts_count + 1)
        ])->save();
    }

    /**
     * Получение элемента статистики за день для заданного шлюза
     * @param Carbon $date
     * @return PaymentGatewayDayStatistic
     */
    private function dayStatisticElem(Carbon $date): PaymentGatewayDayStatistic
    {
        $dateFormat = $date->format('Y-m-d');
        if (!isset($this->dayStatisticItems[ $dateFormat ])) {
            $item = PaymentGatewayDayStatistic::whereDate('date', '=', $date)->where([
                'gateway_id' => $this->gateway->id
            ])->first();
            if (!$item) {
                $item = PaymentGatewayDayStatistic::create($searchData);
            }
            $this->dayStatisticItems[ $dateFormat ] = $item;
        }
        return $this->dayStatisticItems[ $dateFormat ];
    }
}