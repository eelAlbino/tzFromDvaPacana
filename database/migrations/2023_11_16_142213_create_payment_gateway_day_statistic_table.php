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
        Schema::create('payment_gateway_day_statistic', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->default(now())->index()->comment('Дата статистики');
            $table->unsignedBigInteger('gateway_id')->index()->comment('ID шлюза');
            $table->foreign('gateway_id')->references('id')->on('payment_gateways');
            $table->unsignedInteger('attempts_count')->default(0)->comment('Кол-во попыток отправки за день');
        });
        Schema::table('payment_gateway_day_statistic', function (Blueprint $table) {
            $table->unique(['date', 'gateway_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_day_statistic');
    }
};
