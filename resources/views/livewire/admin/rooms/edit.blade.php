<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">Edit Room</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:select wire:model="room_type_id" label="Room Type">
            @foreach ($roomTypes as $roomType)
                <flux:select.option value="{{ $roomType->id }}">{{ $roomType->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:input wire:model="room_number" label="Room Number" />

        <flux:input wire:model="floor" label="Floor" />

        <flux:select wire:model="status" label="Status">
            <flux:select.option value="available">Available</flux:select.option>
            <flux:select.option value="maintenance">Maintenance</flux:select.option>
        </flux:select>

        <div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                Save Changes
            </flux:button>
        </div>
    </form>
</div>