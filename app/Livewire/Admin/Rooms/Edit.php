<?php

namespace App\Livewire\Admin\Rooms;

use App\Models\Room;
use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public Room $room;

    public ?int $room_type_id = null;

    public string $room_number = '';

    public string $floor = '';

    public string $status = 'available';

    public function mount(Room $room): void
    {
        $this->room = $room;
        $this->room_type_id = $room->room_type_id;
        $this->room_number = $room->room_number;
        $this->floor = $room->floor ?? '';
        $this->status = $room->status;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_number')
                    ->where('room_type_id', $this->room_type_id)
                    ->ignore($this->room->id),
            ],
            'floor' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:available,maintenance'],
        ]);

        $this->room->update($validated);

        Flux::toast(variant: 'success', text: __('Room updated.'));

        $this->redirectRoute('admin.rooms.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.rooms.edit', [
            'roomTypes' => RoomType::orderBy('name')->get(),
        ]);
    }
}