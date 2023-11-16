<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Иван Иванов',
            'email' => 'сustomer1@mail.com',
        ]);
        User::factory()->create([
            'name' => 'Пётр Петров',
            'email' => 'сustomer2@mail.com',
        ]);
    }
}
