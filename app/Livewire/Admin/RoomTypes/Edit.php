<?php

namespace App\Livewire\Admin\RoomTypes;

use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public RoomType $roomType;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $base_price = '';

    public int $capacity = 2;

    public function mount(RoomType $roomType): void
    {
        $this->roomType = $roomType;
        $this->name = $roomType->name;
        $this->slug = $roomType->slug;
        $this->description = $roomType->description ?? '';
        $this->base_price = (string) $roomType->base_price;
        $this->capacity = $roomType->capacity;
    }

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:room_types,slug,' . $this->roomType->id],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $this->roomType->update($validated);

        Flux::toast(variant: 'success', text: __('Room type updated.'));

        $this->redirectRoute('admin.room-types.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.room-types.edit');
    }
}