<?php

namespace App\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public PaymentMethod $paymentMethod;

    public string $name = '';

    public string $slug = '';

    public string $instructions = '';

    public bool $requires_proof = false;

    public bool $is_active = true;

    public function mount(PaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
        $this->name = $paymentMethod->name;
        $this->slug = $paymentMethod->slug;
        $this->instructions = $paymentMethod->instructions ?? '';
        $this->requires_proof = $paymentMethod->requires_proof;
        $this->is_active = $paymentMethod->is_active;
    }

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:payment_methods,slug,' . $this->paymentMethod->id],
            'instructions' => ['nullable', 'string'],
            'requires_proof' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $this->paymentMethod->update($validated);

        Flux::toast(variant: 'success', text: __('Payment method updated.'));

        $this->redirectRoute('admin.payment-methods.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.payment-methods.edit');
    }
}
