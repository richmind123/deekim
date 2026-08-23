<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Confirm Your Booking</h1>

    <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 mb-6">
        <h2 class="font-semibold mb-2">{{ $roomType->name }}</h2>
        <p>Check In: {{ $check_in }}</p>
        <p>Check Out: {{ $check_out }}</p>
        <p>Guests: {{ $guests }}</p>
        <p>Nights: {{ $this->nights() }}</p>
        <p class="font-semibold mt-2">Total: ${{ number_format($this->totalPrice(), 2) }}</p>
    </div>
</div>