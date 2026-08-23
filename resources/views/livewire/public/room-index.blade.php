@php use Illuminate\Support\Facades\Storage; @endphp
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">All Rooms</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($roomTypes as $roomType)
            <a href="{{ route('rooms.show', $roomType) }}" wire:navigate class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden block">
                @php $primaryImage = $roomType->images->firstWhere('is_primary', true); @endphp
                @if ($primaryImage)
                    <img src="{{ Storage::disk('public')->url($primaryImage->path) }}" class="w-full h-40 object-cover" />
                @endif

                <div class="p-4">
                    <h3 class="font-semibold">{{ $roomType->name }}</h3>
                    <p class="text-sm">From ${{ $roomType->base_price }} / night</p>
                    <p class="text-sm">Sleeps {{ $roomType->capacity }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>