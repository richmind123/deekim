<?php

namespace App\Livewire\Public;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.public.home', [
            'featuredRoomTypes' => RoomType::with('images')->latest()->take(3)->get(),
        ]);
    }
}