<?php

namespace App\Livewire\Admin\Rooms;

use App\Models\Room;
use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')]
class Create extends Component
{
    public ?int $room_type_id = null;

    public string $room_number = '';

    public string $floor = '';

    public function save(): void
    {
        $validated = $this->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_number')->where('room_type_id', $this->room_type_id),
            ],
            'floor' => ['nullable', 'string', 'max:255'],
        ]);

        Room::create($validated + ['status' => 'available']);

        Flux::toast(variant: 'success', text: __('Room created.'));

        $this->redirectRoute('admin.rooms.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.rooms.create', [
            'roomTypes' => RoomType::orderBy('name')->get(),
        ]);
    }
}