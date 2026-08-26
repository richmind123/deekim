<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $users = User::withCount('bookings')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ]);
    }
}