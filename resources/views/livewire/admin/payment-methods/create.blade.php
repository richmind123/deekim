<div class="p-6">
    <h1 class="text-xl font-bold mb-4">New Payment Method</h1>

    <form wire:submit="save" class="space-y-4 max-w-lg">
        <flux:input wire:model.live="name" label="Name" />
        <flux:input wire:model="slug" label="Slug" />
        <flux:textarea wire:model="instructions" label="Instructions" placeholder="Shown to guests at checkout (e.g. bank account details)" />
        <flux:checkbox wire:model="requires_proof" label="Requires payment proof upload" />
        <flux:checkbox wire:model="is_active" label="Active" />

        <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
            Save Payment Method
        </flux:button>
    </form>
</div>