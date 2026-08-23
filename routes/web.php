<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin;

Route::view('/', 'welcome')->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::livewire('room-types', Admin\RoomTypes\Index::class)->name('room-types.index');
    Route::livewire('room-types/create', Admin\RoomTypes\Create::class)->name('room-types.create');
    Route::livewire('room-types/{roomType}/edit', Admin\RoomTypes\Edit::class)->name('room-types.edit');
    Route::livewire('rooms', Admin\Rooms\Index::class)->name('rooms.index');
    Route::livewire('rooms/create', Admin\Rooms\Create::class)->name('rooms.create');
    Route::livewire('rooms/{room}/edit', Admin\Rooms\Edit::class)->name('rooms.edit');
});


require __DIR__ . '/settings.php';
