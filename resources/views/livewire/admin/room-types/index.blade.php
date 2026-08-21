<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Room Types</h1>

    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-neutral-200 dark:border-neutral-700">
                <th class="py-2">Name</th>
                <th class="py-2">Price</th>
                <th class="py-2">Capacity</th>
                <th class="py-2">Rooms</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roomTypes as $roomType)
                <tr class="border-b border-neutral-200 dark:border-neutral-700">
                    <td class="py-2">{{ $roomType->name }}</td>
                    <td class="py-2">${{ $roomType->base_price }}</td>
                    <td class="py-2">{{ $roomType->capacity }}</td>
                    <td class="py-2">{{ $roomType->rooms()->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>