<div class="space-y-6">
    <flux:heading size="xl">Users</flux:heading>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>Role</flux:table.column>
            <flux:table.column>Bookings</flux:table.column>
            <flux:table.column>Joined</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($users as $user)
                <flux:table.row wire:key="user-{{ $user->id }}">
                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$user->isAdmin() ? 'blue' : 'zinc'">
                            {{ ucfirst($user->role) }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>{{ $user->bookings_count }}</flux:table.cell>
                    <flux:table.cell>{{ $user->created_at->format('M j, Y') }}</flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">
                        No users found.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    {{ $users->links() }}
</div>