<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">My Bookings</h1>

    <h2 class="font-semibold mb-3">Upcoming</h2>
    @forelse ($upcomingBookings as $booking)
        <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 mb-4">
            <p class="font-semibold">{{ $booking->roomType->name }}</p>
            <p>{{ $booking->check_in->format('M j, Y') }} &rarr; {{ $booking->check_out->format('M j, Y') }}</p>
            <p>Reference: {{ $booking->reference }}</p>
            <p class="mb-3">Status: {{ ucfirst($booking->status) }}</p>

            <flux:button wire:click="cancel({{ $booking->id }})" wire:confirm="Are you sure you want to cancel this booking?" size="sm">
                Cancel Booking
            </flux:button>
        </div>
    @empty
        <p class="text-sm mb-6">No upcoming bookings.</p>
    @endforelse

    <h2 class="font-semibold mb-3 mt-8">Past</h2>
    @forelse ($pastBookings as $booking)
        <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 mb-4">
            <p class="font-semibold">{{ $booking->roomType->name }}</p>
            <p>{{ $booking->check_in->format('M j, Y') }} &rarr; {{ $booking->check_out->format('M j, Y') }}</p>
            <p>Reference: {{ $booking->reference }}</p>
        </div>
    @empty
        <p class="text-sm">No past bookings.</p>
    @endforelse
</div>