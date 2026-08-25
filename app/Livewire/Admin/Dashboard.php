<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $todaysBookings = Booking::whereDate('check_in', $today)
            ->where('status', '!=', 'cancelled')
            ->count();

        $monthRevenue = Booking::where('status', '!=', 'cancelled')
            ->whereBetween('check_in', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])
            ->sum('total_price');

        $occupancy = Booking::selectRaw('DATE(check_in) as date, COUNT(*) as bookings, SUM(total_price) as revenue')
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '>=', $today->copy()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('livewire.admin.dashboard', [
            'todaysBookings' => $todaysBookings,
            'monthRevenue' => $monthRevenue,
            'occupancy' => $occupancy,
        ]);
    }
}