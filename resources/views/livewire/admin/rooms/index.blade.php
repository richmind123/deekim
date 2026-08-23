<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Rooms</h1>

    <flux:button href="{{ route('admin.rooms.create') }}" wire:navigate class="mb-4">
        New Room
    </flux:button>

    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-neutral-200 dark:border-neutral-700">
                <th class="py-2">Room Number</th>
                <th class="py-2">Room Type</th>
                <th class="py-2">Floor</th>
                <th class="py-2">Status</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr class="border-b border-neutral-200 dark:border-neutral-700">
                    <td class="py-2">{{ $room->room_number }}</td>
                    <td class="py-2">{{ $room->roomType->name }}</td>
                    <td class="py-2">{{ $room->floor ?? '—' }}</td>
                    <td class="py-2">
                        @if ($room->status === 'available')
                            <flux:badge color="green">Available</flux:badge>
                        @else
                            <flux:badge color="amber">Maintenance</flux:badge>
                        @endif
                    </td>
                    <td class="py-2">
                        <flux:button href="{{ route('admin.rooms.edit', $room) }}" wire:navigate size="sm">
                            Edit
                        </flux:button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>