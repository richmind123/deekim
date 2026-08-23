<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Confirmation extends Component
{
    public Booking $booking;

    public function mount(Booking $booking): void
    {
        $this->booking = $booking;
    }

    public function render()
    {
        return view('livewire.booking.confirmation');
    }
}