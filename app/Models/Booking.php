<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    public function hotel_room(): BelongsTo
    {
        return $this->belongsTo(HotelRoom::class);
    }
}
