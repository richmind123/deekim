<div class="p-6 max-w-xl">
    @if ($booking->status === 'confirmed')
        <h1 class="text-2xl font-bold mb-2">Booking Confirmed!</h1>
        <p class="mb-6">Your reference number is <strong>{{ $booking->reference }}</strong></p>
    @elseif ($booking->status === 'pending_payment')
        <h1 class="text-2xl font-bold mb-2">Booking Received</h1>
        <p class="mb-6">
            Your reference number is <strong>{{ $booking->reference }}</strong>.
            We're verifying your payment — you'll receive a confirmation email once it's approved.
        </p>
    @else
        <h1 class="text-2xl font-bold mb-2">Booking {{ ucfirst($booking->status) }}</h1>
        <p class="mb-6">Your reference number is <strong>{{ $booking->reference }}</strong></p>
    @endif

    <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
        <p>{{ $booking->roomType->name }}</p>
        <p>{{ $booking->check_in->format('M j, Y') }} &rarr; {{ $booking->check_out->format('M j, Y') }}</p>
        <p>{{ $booking->guests }} guest{{ $booking->guests > 1 ? 's' : '' }}</p>
        <p class="font-semibold mt-2">Total: ${{ number_format($booking->total_price, 2) }}</p>
    </div>
</div>