<?php

namespace App\Livewire\Public;

use App\Models\Booking;
use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class RoomShow extends Component
{
    public RoomType $roomType;

    public string $check_in = '';

    public string $check_out = '';

    public int $guests = 1;

    public ?int $availableRooms = null;

    public bool $searched = false;

    public function mount(RoomType $roomType): void
    {
        $this->roomType = $roomType;
    }

    public function updatedCheckIn(): void
    {
        $this->searched = false;
    }

    public function updatedCheckOut(): void
    {
        $this->searched = false;
    }

    public function checkAvailability(): void
    {
        $this->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1'],
        ]);

        $overlapping = Booking::where('room_type_id', $this->roomType->id)
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<', $this->check_out)
            ->where('check_out', '>', $this->check_in)
            ->count();

        $this->availableRooms = $this->roomType->rooms()->count() - $overlapping;
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.public.room-show');
    }
}