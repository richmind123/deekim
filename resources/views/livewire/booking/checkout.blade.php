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

    <form wire:submit="confirmBooking">
        @error('dates')
            <p class="text-red-600 dark:text-red-400 mb-4">{{ $message }}</p>
        @enderror

        <div class="mb-6">
            <h2 class="font-semibold mb-3">Payment Method</h2>

            <div class="space-y-2">
                @foreach ($paymentMethods as $method)
                    <label class="flex items-start gap-3 border border-neutral-200 dark:border-neutral-700 rounded-lg p-3 cursor-pointer">
                        <input type="radio" wire:model.live="paymentMethodId" value="{{ $method->id }}" class="mt-1" />
                        <span>
                            <span class="block font-medium">{{ $method->name }}</span>
                            @if ($method->instructions)
                                <span class="block text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $method->instructions }}
                                </span>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>

            @error('paymentMethodId')
                <p class="text-red-600 dark:text-red-400 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </div>

        @if ($this->selectedMethod()?->requires_proof)
            <div class="mb-6">
                <flux:input type="file" wire:model="proof" label="Upload Payment Proof" accept="image/*" />

                @error('proof')
                    <p class="text-red-600 dark:text-red-400 mt-2 text-sm">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="confirmBooking">
            Confirm Booking
        </flux:button>
    </form>
</div>