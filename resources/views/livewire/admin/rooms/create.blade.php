<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">New Room</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:select wire:model="room_type_id" label="Room Type">
            <flux:select.option value="">Select a room type</flux:select.option>
            @foreach ($roomTypes as $roomType)
                <flux:select.option value="{{ $roomType->id }}">{{ $roomType->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:input wire:model="room_number" label="Room Number" />

        <flux:input wire:model="floor" label="Floor" />

        <div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                Create Room
            </flux:button>
        </div>
    </form>
</div>