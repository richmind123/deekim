<?php

namespace App\Livewire\Bookings;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Index extends Component
{
    public function render()
    {
        $bookings = Auth::user()->bookings()->with('roomType')->latest()->get();

        return view('livewire.bookings.index', [
            'upcomingBookings' => $bookings->where('check_out', '>=', now())->where('status', '!=', 'cancelled'),
            'pastBookings' => $bookings->where('check_out', '<', now()),
        ]);
    }
}