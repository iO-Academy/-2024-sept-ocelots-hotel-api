<?php

namespace Tests\Unit;

use App\Models\HotelRoom;
use App\Services\BookingService;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    public function test_room_capacity_good()
    {
        $fakeRoom = new HotelRoom;
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 4;

        $actualGood = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $this->assertTrue($actualGood);
    }

    public function test_room_capacity_low()
    {
        $fakeRoom = new HotelRoom;
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 2;

        $actualLow = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $this->assertFalse($actualLow);
    }

    public function test_room_capacity_high()
    {
        $fakeRoom = new HotelRoom;
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 7;

        $actualHigh = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $this->assertFalse($actualHigh);
    }
}
