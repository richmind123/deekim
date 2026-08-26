<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Payment Methods</h1>

    <flux:button href="{{ route('admin.payment-methods.create') }}" wire:navigate class="mb-4">
        New Payment Method
    </flux:button>

    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-neutral-200 dark:border-neutral-700">
                <th class="py-2">Name</th>
                <th class="py-2">Slug</th>
                <th class="py-2">Requires Proof</th>
                <th class="py-2">Active</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paymentMethods as $paymentMethod)
                <tr class="border-b border-neutral-200 dark:border-neutral-700">
                    <td class="py-2">{{ $paymentMethod->name }}</td>
                    <td class="py-2">{{ $paymentMethod->slug }}</td>
                    <td class="py-2">{{ $paymentMethod->requires_proof ? 'Yes' : 'No' }}</td>
                    <td class="py-2">
                        <flux:badge :color="$paymentMethod->is_active ? 'green' : 'zinc'">
                            {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                        </flux:badge>
                    </td>
                    <td class="py-2 space-x-2">
                        <flux:button href="{{ route('admin.payment-methods.edit', $paymentMethod) }}" wire:navigate size="sm">
                            Edit
                        </flux:button>
                        <flux:button wire:click="toggleActive({{ $paymentMethod->id }})" wire:loading.attr="disabled" wire:target="toggleActive({{ $paymentMethod->id }})" size="sm" variant="{{ $paymentMethod->is_active ? 'danger' : 'primary' }}">
                            {{ $paymentMethod->is_active ? 'Deactivate' : 'Activate' }}
                        </flux:button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>