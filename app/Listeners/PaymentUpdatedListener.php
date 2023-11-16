<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PaymentUpdated;
use App\Jobs\SendUpdatedPaymentToGatewayJob;

class PaymentUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentUpdated $event): void
    {
        // Если отправка должна выполняться независимо от текущего процесса, надо настроить работу очередей
        SendUpdatedPaymentToGatewayJob::dispatch($event->payment->id);
    }
    
}
