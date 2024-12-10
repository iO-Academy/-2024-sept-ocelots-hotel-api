<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Services\DateService;
use PHPUnit\Framework\TestCase;

class DateServiceTest extends TestCase
{
    public function testValidEndDateGood()
    {
        $inputStartDate = '2025-04-15';
        $inputEndDate = '2025-04-30';
        $actualGood = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function testValidEndDateBad()
    {
        $inputStartDate = '2025-04-15';
        $inputEndDate = '2024-04-30';
        $actualBad = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedBad = false;
        $this->assertEquals($expectedBad, $actualBad);
    }

    public function testValidEndDateInvalid()
    {
        $inputStartDate = 'no';
        $inputEndDate = 'whelp';
        $actualInvalid = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedInvalid = false;
        $this->assertEquals($expectedInvalid, $actualInvalid);
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

    public function testAvailableDateGood()
    {
        $fakeConfirmedBooking = new Booking();
        $fakeAttemptedBooking = new Booking();
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-05-20';
        $fakeAttemptedBooking->end = '2025-05-30';


        $actualGood = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function testAvailableDateBadStart()
    {
        $fakeConfirmedBooking = new Booking();
        $fakeAttemptedBooking = new Booking();
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-04-20';
        $fakeAttemptedBooking->end = '2025-05-30';
        $actualBadStart = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedBadStart = false;
        $this->assertEquals($expectedBadStart, $actualBadStart);
    }

    public function testAvailableDateBadEnd()
    {
        $fakeConfirmedBooking = new Booking();
        $fakeAttemptedBooking = new Booking();
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-03-20';
        $fakeAttemptedBooking->end = '2025-04-30';
        $actualBadEnd = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedBadEnd = false;
        $this->assertEquals($expectedBadEnd, $actualBadEnd);
    }
}
