<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class HotelRoom extends Model
{
    public function room_types(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
