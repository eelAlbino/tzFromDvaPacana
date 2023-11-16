<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('guid')->index()->comment('Внешний ID платежа');
            $table->unsignedBigInteger('customer_id')->index()->comment('ID клиента');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('gateway_id')->index()->comment('ID шлюза');
            $table->foreign('gateway_id')->references('id')->on('payment_gateways');
            $table->string('status')->index()->comment('Код внутреннего статуса');
            $table->foreign('status')->references('code')->on('payment_statuses');
            $table->unsignedBigInteger('amount')->comment('К оплате (число в центах)'); // По задаче надо использовать int, но вообще можно поставить decimal.
            $table->unsignedBigInteger('amount_paid')->default(0)->comment('Уже оплачено (число в центах)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
