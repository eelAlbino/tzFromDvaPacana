<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentGateway;

class PaymentGatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Первый шлюз с json телом и sha хешем
        PaymentGateway::factory()->create([
            'code' => 'test_first'
        ]);
        // Второй шлюз с form-data телом и md5 хешем
        PaymentGateway::factory()->create([
            'code' => 'test_second'
        ]);
    }
}
