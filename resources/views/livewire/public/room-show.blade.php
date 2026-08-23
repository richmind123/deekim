@php use Illuminate\Support\Facades\Storage; @endphp
<div class="p-6 max-w-3xl">
    @php $primaryImage = $roomType->images->firstWhere('is_primary', true); @endphp
    @if ($primaryImage)
        <img src="{{ Storage::disk('public')->url($primaryImage->path) }}" class="w-full h-64 object-cover rounded-lg mb-6" />
    @endif

    <h1 class="text-2xl font-bold mb-2">{{ $roomType->name }}</h1>
    <p class="text-lg mb-4">${{ $roomType->base_price }} / night - Sleeps {{ $roomType->capacity }}</p>

    @if ($roomType->description)
        <p class="mb-6">{{ $roomType->description }}</p>
    @endif

    <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 mb-6">
        <h2 class="font-semibold mb-4">Check Availability</h2>

        <form wire:submit="checkAvailability" class="flex flex-wrap gap-4 items-end">
            <flux:input type="date" wire:model="check_in" label="Check In" />
            <flux:input type="date" wire:model="check_out" label="Check Out" />
            <flux:input type="number" wire:model="guests" label="Guests" min="1" />

            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="checkAvailability">
                Search
            </flux:button>
        </form>

        @if ($searched)
            <div class="mt-4">
                @if ($availableRooms > 0)
                    <p class="text-green-600 dark:text-green-400 mb-3">
                        {{ $availableRooms }} room{{ $availableRooms > 1 ? 's' : '' }} available for these dates.
                    </p>

                    <flux:button wire:click="bookNow" variant="primary">
                        Book Now
                    </flux:button>
                @else
                    <p class="text-red-600 dark:text-red-400">
                        Sorry, no rooms available for these dates.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <a href="{{ route('rooms.index') }}" wire:navigate class="text-sm underline">
        &larr; Back to all rooms
    </a>
</div>