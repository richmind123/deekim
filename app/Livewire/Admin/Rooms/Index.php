<?php

namespace App\Livewire\Admin\Rooms;

use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.rooms.index', [
            'rooms' => Room::with('roomType')->latest()->get(),
        ]);
    }
}