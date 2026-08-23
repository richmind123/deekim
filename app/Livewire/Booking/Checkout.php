<?php

namespace App\Livewire\Booking;

use App\Models\RoomType;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Checkout extends Component
{
    public RoomType $roomType;

    public string $check_in;

    public string $check_out;

    public int $guests;

    public function mount(): void
    {
        $roomTypeSlug = request('roomType');
        $this->roomType = RoomType::where('slug', $roomTypeSlug)->firstOrFail();
        $this->check_in = request('check_in', '');
        $this->check_out = request('check_out', '');
        $this->guests = (int) request('guests', 1);
    }

    public function nights(): int
    {
        return Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out));
    }

    public function totalPrice(): float
    {
        return $this->nights() * $this->roomType->base_price;
    }

    public function render()
    {
        return view('livewire.booking.checkout');
    }
}