<?php

namespace App\Services;

use App\Models\HotelRoom;
use Carbon\Laravel\ServiceProvider;

class BookingService extends ServiceProvider
{
    public static function isRoomCapacityValid(HotelRoom $room, int $guests): bool
    {
        $minCapacity = $room->min_capacity;
        $maxCapacity = $room->max_capacity;

//        dd($maxCapacity);
        if ($guests < $minCapacity)
        {
            return false;
        } elseif ($guests > $maxCapacity)
        {
            return false;
        } else
        {
            return true;
        }
    }
}
