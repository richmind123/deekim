<?php

namespace App\Livewire\Admin\RoomTypes;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.room-types.index', [
            'roomTypes' => RoomType::with('images')->latest()->get(),
        ]);
    }
}