<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\RoomType;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

    public function confirmBooking(): void
    {
        $booking = DB::transaction(function () {
            $overlapping = Booking::where('room_type_id', $this->roomType->id)
                ->where('status', '!=', 'cancelled')
                ->where('check_in', '<', $this->check_out)
                ->where('check_out', '>', $this->check_in)
                ->lockForUpdate()
                ->count();

            if ($overlapping >= $this->roomType->rooms()->count()) {
                throw ValidationException::withMessages([
                    'dates' => 'Sorry, this room just sold out for those dates.',
                ]);
            }

            return Booking::create([
                'user_id' => Auth::id(),
                'room_type_id' => $this->roomType->id,
                'reference' => 'DKM-' . strtoupper(Str::random(6)),
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'guests' => $this->guests,
                'status' => 'confirmed',
                'total_price' => $this->totalPrice(),
            ]);
        });

        $booking->user->notify(new \App\Notifications\BookingConfirmed($booking));

        Flux::toast(variant: 'success', text: __('Booking confirmed!'));

        $this->redirectRoute('booking.confirmation', ['booking' => $booking->id], navigate: true);
    }

    public function render()
    {
        return view('livewire.booking.checkout');
    }
}