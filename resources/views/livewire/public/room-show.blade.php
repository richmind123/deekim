@php use Illuminate\Support\Facades\Storage; @endphp
<div class="p-6 max-w-3xl">
    @php $primaryImage = $roomType->images->firstWhere('is_primary', true); @endphp
    @if ($primaryImage)
        <img src="{{ Storage::disk('public')->url($primaryImage->path) }}" class="w-full h-64 object-cover rounded-lg mb-6" />
    @endif

    <h1 class="text-2xl font-bold mb-2">{{ $roomType->name }}</h1>
    <p class="text-lg mb-4">${{ $roomType->base_price }} / night · Sleeps {{ $roomType->capacity }}</p>

    @if ($roomType->description)
        <p class="mb-6">{{ $roomType->description }}</p>
    @endif

    <a href="{{ route('rooms.index') }}" wire:navigate class="text-sm underline">
        &larr; Back to all rooms
    </a>
</div>