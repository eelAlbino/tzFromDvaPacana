<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрируем классы работы со шлюзами
        $this->app->bind('payment_gateway_test_first', \App\PaymentGateways\TestFirst\Gateway::class);
        $this->app->bind('payment_gateway_test_second', \App\PaymentGateways\TestSecond\Gateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
