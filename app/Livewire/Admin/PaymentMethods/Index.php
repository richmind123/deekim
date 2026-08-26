<?php

namespace App\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function toggleActive(PaymentMethod $paymentMethod): void
    {
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.payment-methods.index', [
            'paymentMethods' => PaymentMethod::latest()->get(),
        ]);
    }
}