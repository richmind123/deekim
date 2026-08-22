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
class Create extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $base_price = '';

    public int $capacity = 2;

    public $photo;

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
            'slug' => ['required', 'string', 'max:255', 'unique:room_types,slug'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $roomType = RoomType::create(collect($validated)->except('photo')->toArray());

        if ($this->photo) {
            $path = Storage::disk('public')->putFile('room-types', $this->photo);

            $roomType->images()->create([
                'path' => $path,
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        Flux::toast(variant: 'success', text: __('Room type created.'));

        $this->redirectRoute('admin.room-types.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.room-types.create');
    }
}