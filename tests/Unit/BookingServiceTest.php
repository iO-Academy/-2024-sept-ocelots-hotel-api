<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\HotelRoom;
use App\Services\BookingService;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    public function testRoomCapacityGood()
    {
        $fakeRoom = new HotelRoom();
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 4;

        $actualGood = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function testRoomCapacityLow()
    {
        $fakeRoom = new HotelRoom();
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 2;

        $actualLow = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $expectedLow = false;
        $this->assertEquals($expectedLow, $actualLow);
    }

    public function testRoomCapacityHigh()
    {
        $fakeRoom = new HotelRoom();
        $fakeRoom->min_capacity = 3;
        $fakeRoom->max_capacity = 5;
        $fakeGuests = 7;

        $actualHigh = BookingService::isRoomCapacityValid($fakeRoom, $fakeGuests);
        $expectedHigh = false;
        $this->assertEquals($expectedHigh, $actualHigh);
    }
}
