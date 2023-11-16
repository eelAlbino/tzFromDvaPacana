<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentStatus;

class PaymentStatusesSeeder extends Seeder
{
    /**
     * Добавление статусов оплаты.
     * Все эти статусы по идее можно было бы добавить и через миграцию, но я строгой зависимости в задаче не увидел.
     */
    public function run(): void
    {
        PaymentStatus::factory()->create([
            'code' => 'created',
            'name' => 'Создана'
        ]);
        PaymentStatus::factory()->create([
            'code' => 'pending',
            'name' => 'В процессе оплаты'
        ]);
        PaymentStatus::factory()->create([
            'code' => 'completed',
            'name' => 'Выполнена'
        ]);
        PaymentStatus::factory()->create([
            'code' => 'expired',
            'name' => 'Истек срок жизни'
        ]);
        PaymentStatus::factory()->create([
            'code' => 'rejected',
            'name' => 'Отклонена'
        ]);
    }
}
