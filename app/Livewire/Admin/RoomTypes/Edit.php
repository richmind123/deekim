<?php

namespace App\Livewire\Admin\RoomTypes;

use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public RoomType $roomType;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $base_price = '';

    public int $capacity = 2;

    public $photo;

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

    public function updatedPhoto(): void
    {
        $this->resetErrorBag('photo');
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:room_types,slug,' . $this->roomType->id],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $this->roomType->update(collect($validated)->except('photo')->toArray());

        if ($this->photo) {
            $path = Storage::disk('public')->putFile('room-types', $this->photo);

            $this->roomType->images()->update(['is_primary' => false]);

            $this->roomType->images()->create([
                'path' => $path,
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        Flux::toast(variant: 'success', text: __('Room type updated.'));

        $this->redirectRoute('admin.room-types.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.room-types.edit', [
            'existingImage' => $this->roomType->images()->where('is_primary', true)->first(),
        ]);
    }
}