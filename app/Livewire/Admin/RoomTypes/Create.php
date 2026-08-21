<?php

namespace App\Livewire\Admin\RoomTypes;

use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $base_price = '';

    public int $capacity = 2;

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:room_types,slug'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        RoomType::create($validated);

        Flux::toast(variant: 'success', text: __('Room type created.'));

        $this->redirectRoute('admin.room-types.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.room-types.create');
    }
}