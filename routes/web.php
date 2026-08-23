<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin;
use App\Livewire\Public;

Route::livewire('/', Public\Home::class)->name('home');
Route::livewire('rooms', Public\RoomIndex::class)->name('rooms.index');
Route::livewire('rooms/{roomType:slug}', Public\RoomShow::class)->name('rooms.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('booking/checkout', \App\Livewire\Booking\Checkout::class)->name('booking.checkout');
    Route::livewire('booking/confirmation/{booking}', \App\Livewire\Booking\Confirmation::class)->name('booking.confirmation');
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