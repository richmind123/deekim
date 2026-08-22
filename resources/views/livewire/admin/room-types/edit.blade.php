@php use Illuminate\Support\Facades\Storage; @endphp
<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">Edit Room Type</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:input wire:model.live="name" label="Name" />

        <flux:input wire:model="slug" label="Slug" description="Auto-generated from the name, but you can override it." />

        <flux:textarea wire:model="description" label="Description" />

        <flux:input wire:model="base_price" label="Base price" type="number" step="0.01" />

        <flux:input wire:model="capacity" label="Capacity" type="number" />

        @if ($existingImage)
            <div>
                <p class="text-sm mb-1">Current photo</p>
                <img src="{{ Storage::disk('public')->url($existingImage->path) }}" class="w-24 h-24 object-cover rounded-lg" />
            </div>
        @endif

        <flux:input type="file" wire:model="photo" label="{{ $existingImage ? 'Replace / add another photo' : 'Photo' }}" accept="image/*" />

        @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}" class="w-40 h-40 object-cover rounded-lg" />
        @endif

        <div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                Save Changes
            </flux:button>
        </div>
    </form>
</div>