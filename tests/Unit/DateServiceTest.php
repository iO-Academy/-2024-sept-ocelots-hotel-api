<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Services\DateService;
use PHPUnit\Framework\TestCase;

class DateServiceTest extends TestCase
{
    public function testValidEndDate()
    {
        $inputStartDate = 2025-04-15;
        $inputEndDate = 2025-04-30;

    }

    public function testFutureDateGood()
    {
        $inputGoodFutureDate = '2200-04-16';
        $actualGood = DateService::futureDate($inputGoodFutureDate);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function testFutureDateBad()
    {
        $inputBadFutureDate = '2010-03-05';
        $actualBad = DateService::futureDate($inputBadFutureDate);
        $expectedBad = false;
        $this->assertEquals($expectedBad, $actualBad);
    }

    public function testFutureDateNotDate()
    {
        $inputNotDate = 'gloob';
        $actualNotDate = DateService::futureDate($inputNotDate);
        $expectedNotDate = false;
        $this->assertEquals($expectedNotDate, $actualNotDate);

    }

    public function testAvailableDate()
    {
        $fakeConfirmedBooking = $this->createMock(Booking::class);
//        $fakeConfirmedBooking->start=;

    }
}
