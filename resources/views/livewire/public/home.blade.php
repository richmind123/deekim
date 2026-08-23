@php use Illuminate\Support\Facades\Storage; @endphp
<div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Welcome to Deekim</h1>
    <p class="mb-6">Find your room and book your stay.</p>

    <h2 class="text-lg font-semibold mb-4">Featured Rooms</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($featuredRoomTypes as $roomType)
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
                @php $primaryImage = $roomType->images->firstWhere('is_primary', true); @endphp
                @if ($primaryImage)
                    <img src="{{ Storage::disk('public')->url($primaryImage->path) }}" class="w-full h-40 object-cover" />
                @endif

                <div class="p-4">
                    <h3 class="font-semibold">{{ $roomType->name }}</h3>
                    <p class="text-sm">From ${{ $roomType->base_price }} / night</p>
                </div>
            </div>
        @endforeach
    </div>
</div>