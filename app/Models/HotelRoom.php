<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelRoom extends Model
{
    use HasFactory;

    public $hidden = ['type_id', 'created_at', 'updated_at'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}
