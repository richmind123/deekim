<?php

namespace App\Livewire\Public;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class RoomIndex extends Component
{
    public function render()
    {
        return view('livewire.public.room-index', [
            'roomTypes' => RoomType::with('images')->orderBy('name')->get(),
        ]);
    }
}