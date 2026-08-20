<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        RoomType::factory()
            ->count(5)
            ->create()
            ->each(function (RoomType $roomType) {
                Room::factory()
                    ->count(fake()->numberBetween(2, 6))
                    ->create(['room_type_id' => $roomType->id]);
            });
    }
}