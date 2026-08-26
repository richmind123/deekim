<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
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

    public function updated($property)
    {
        if (in_array($property, ['status', 'from', 'to'])) {
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

    public function render()
    {
        $bookings = Booking::with(['user', 'roomType'])
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->from, fn($query) => $query->whereDate('check_in', '>=', $this->from))
            ->when($this->to, fn($query) => $query->whereDate('check_in', '<=', $this->to))
            ->latest('check_in')
            ->paginate(15);

        return view('livewire.admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }
}
