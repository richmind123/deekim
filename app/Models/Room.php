<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['room_type_id', 'room_number', 'floor', 'status'])]
class Room extends Model
{
    use HasFactory;

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}