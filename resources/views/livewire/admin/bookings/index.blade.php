@php use Illuminate\Support\Facades\Storage; @endphp
<div class="space-y-6">
    <flux:heading size="xl">Bookings</flux:heading>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <flux:select wire:model.live="status" label="Status">
            <flux:select.option value="">All statuses</flux:select.option>
            <flux:select.option value="confirmed">Confirmed</flux:select.option>
            <flux:select.option value="cancelled">Cancelled</flux:select.option>
        </flux:select>

        <flux:input type="date" wire:model.live="from" label="Check-in from" />
        <flux:input type="date" wire:model.live="to" label="Check-in to" />
        <flux:checkbox wire:model.live="staleOnly" label="Show stale pending payments only (6+ hours)" />
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Reference</flux:table.column>
            <flux:table.column>Guest</flux:table.column>
            <flux:table.column>Room Type</flux:table.column>
            <flux:table.column>Check-in</flux:table.column>
            <flux:table.column>Check-out</flux:table.column>
            <flux:table.column>Nights</flux:table.column>
            <flux:table.column>Total</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($bookings as $booking)
                <flux:table.row wire:key="booking-{{ $booking->id }}">
                    <flux:table.cell>{{ $booking->reference }}</flux:table.cell>
                    <flux:table.cell>{{ $booking->user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $booking->roomType->name }}</flux:table.cell>
                    <flux:table.cell>{{ $booking->check_in->format('M j, Y') }}</flux:table.cell>
                    <flux:table.cell>{{ $booking->check_out->format('M j, Y') }}</flux:table.cell>
                    <flux:table.cell>{{ $booking->nights() }}</flux:table.cell>
                    <flux:table.cell>${{ number_format($booking->total_price, 2) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$booking->status === 'confirmed' ? 'green' : ($booking->status === 'pending_payment' ? 'amber' : 'red')">
                            {{ ucfirst($booking->status) }}
                        </flux:badge>
                        @if ($booking->status === 'pending_payment')
                            <span class="text-xs {{ $this->isStale($booking) ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-neutral-500' }}">
                                ({{ $booking->created_at->diffForHumans(null, true) }}{{ $this->isStale($booking) ? ' — overdue' : '' }})
                            </span>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        @if ($booking->status === 'pending_payment')
                            @if ($booking->payment?->proof_path)
                                <flux:button size="sm" href="{{ Storage::disk('public')->url($booking->payment->proof_path) }}" target="_blank">
                                    View Proof
                                </flux:button>
                            @endif
                            <flux:button size="sm" variant="primary" wire:click="approvePayment({{ $booking->id }})" wire:loading.attr="disabled" wire:target="approvePayment({{ $booking->id }})" wire:confirm="Approve this payment? The guest will be notified.">
                                Approve
                            </flux:button>
                            <flux:button size="sm" variant="danger" wire:click="rejectPayment({{ $booking->id }})" wire:loading.attr="disabled" wire:target="rejectPayment({{ $booking->id }})" wire:confirm="Reject this payment? The booking will be cancelled.">
                                Reject
                            </flux:button>
                        @else
                            @if ($booking->status !== 'confirmed')
                                <flux:button size="sm" variant="primary" wire:click="confirm({{ $booking->id }})" wire:loading.attr="disabled" wire:target="confirm({{ $booking->id }})">
                                    Confirm
                                </flux:button>
                            @endif
                            @if ($booking->status !== 'cancelled')
                                <flux:button size="sm" variant="danger" wire:click="cancel({{ $booking->id }})" wire:loading.attr="disabled" wire:target="cancel({{ $booking->id }})" wire:confirm="Cancel this booking?">
                                    Cancel
                                </flux:button>
                            @endif
                        @endif
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="9" class="text-center text-zinc-500">
                        No bookings match these filters.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    {{ $bookings->links() }}
</div>