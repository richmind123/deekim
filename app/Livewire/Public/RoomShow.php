<?php

namespace App\Livewire\Public;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class RoomShow extends Component
{
    public RoomType $roomType;

    public function mount(RoomType $roomType): void
    {
        $this->roomType = $roomType;
    }

    public function render()
    {
        return view('livewire.public.room-show');
    }
}