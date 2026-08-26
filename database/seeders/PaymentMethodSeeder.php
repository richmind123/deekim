<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Pay at Hotel',
            'slug' => 'pay_at_hotel',
            'instructions' => null,
            'requires_proof' => false,
            'is_active' => true,
        ]);

        PaymentMethod::create([
            'name' => 'Bank Transfer',
            'slug' => 'bank_transfer',
            'instructions' => null,
            'requires_proof' => true,
            'is_active' => true,
        ]);
    }
}