<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use App\Notifications\BookingConfirmed;
use Flux\Flux;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $status = '';

    #[Url]
    public string $from = '';

    #[Url]
    public string $to = '';

    #[Url]
    public bool $staleOnly = false;

    public function updated($property)
    {
        if (in_array($property, ['status', 'from', 'to', 'staleOnly'])) {
            $this->resetPage();
        }
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
    }

    public function approvePayment(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        $booking->payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $booking->user->notify(new BookingConfirmed($booking));

        Flux::toast(variant: 'success', text: __('Payment approved — guest notified.'));
    }

    public function rejectPayment(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        $booking->payment->update([
            'status' => 'failed',
        ]);

        Flux::toast(variant: 'danger', text: __('Payment rejected — booking cancelled.'));
    }

    public function isStale(Booking $booking): bool
    {
        return $booking->status === 'pending_payment'
            && $booking->created_at->lt(now()->subHours(6));
    }

    public function render()
    {
        $bookings = Booking::with(['user', 'roomType', 'payment'])
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->from, fn($query) => $query->whereDate('check_in', '>=', $this->from))
            ->when($this->to, fn($query) => $query->whereDate('check_in', '<=', $this->to))
            ->when(
                $this->staleOnly,
                fn($query) => $query
                    ->where('status', 'pending_payment')
                    ->where('created_at', '<', now()->subHours(6))
            )
            ->latest('check_in')
            ->paginate(15);

        return view('livewire.admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }
}