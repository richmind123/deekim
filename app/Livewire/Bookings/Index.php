<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Index extends Component
{
    public function cancel(Booking $booking): void
    {
        $this->authorize('update', $booking);

        $booking->update(['status' => 'cancelled']);

        Flux::toast(variant: 'success', text: __('Booking cancelled.'));
    }

    public function render()
    {
        $bookings = Auth::user()->bookings()->with('roomType')->latest()->get();

        return view('livewire.bookings.index', [
            'upcomingBookings' => $bookings->where('check_out', '>=', now())->where('status', '!=', 'cancelled'),
            'pastBookings' => $bookings->where('check_out', '<', now()),
        ]);
    }
}