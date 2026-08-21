<div class="p-6 max-w-xl">
    <h1 class="text-xl font-bold mb-4">Edit Room Type</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <flux:input wire:model.live="name" label="Name" />

        <flux:input wire:model="slug" label="Slug" description="Auto-generated from the name, but you can override it." />

        <flux:textarea wire:model="description" label="Description" />

        <flux:input wire:model="base_price" label="Base price" type="number" step="0.01" />

        <flux:input wire:model="capacity" label="Capacity" type="number" />

        <div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                Save Changes
            </flux:button>
        </div>
    </form>
</div>