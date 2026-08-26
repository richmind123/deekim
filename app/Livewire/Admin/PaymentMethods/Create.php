<?php

namespace App\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public string $name = '';

    public string $slug = '';

    public string $instructions = '';

    public bool $requires_proof = false;

    public bool $is_active = true;

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:payment_methods,slug'],
            'instructions' => ['nullable', 'string'],
            'requires_proof' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        PaymentMethod::create($validated);

        Flux::toast(variant: 'success', text: __('Payment method created.'));

        $this->redirectRoute('admin.payment-methods.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.payment-methods.create');
    }
}