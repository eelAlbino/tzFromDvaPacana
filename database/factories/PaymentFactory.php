<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\PaymentGateway;
use App\Models\PaymentStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::inRandomOrder()->first();
        if (!$customer) {
            $customer = User::factory()->create();
        }
        $gateway = PaymentGateway::inRandomOrder()->first();
        if (!$gateway) {
            $gateway = PaymentGateway::factory()->create();
        }
        $status = PaymentStatus::inRandomOrder()->first();
        if (!$status) {
            $status = PaymentStatus::factory()->create();
        }
        return [
            'guid' => $this->faker->unique()->randomNumber(8),
            'customer_id' => $customer->id,
            'gateway_id' => $gateway->id,
            'status' => $status->code,
            'amount' => $this->faker->numberBetween(1000, 100000),
            'amount_paid' => 0
        ];
    }
}
