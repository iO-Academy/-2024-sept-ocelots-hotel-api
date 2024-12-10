<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Services\DateService;
use PHPUnit\Framework\TestCase;

class DateServiceTest extends TestCase
{
    public function test_valid_end_date_good()
    {
        $inputStartDate = '2025-04-15';
        $inputEndDate = '2025-04-30';
        $actualGood = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function test_valid_end_date_bad()
    {
        $inputStartDate = '2025-04-15';
        $inputEndDate = '2024-04-30';
        $actualBad = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedBad = false;
        $this->assertEquals($expectedBad, $actualBad);
    }

    public function test_valid_end_date_invalid()
    {
        $inputStartDate = 'no';
        $inputEndDate = 'whelp';
        $actualInvalid = DateService::validEndDate($inputStartDate, $inputEndDate);
        $expectedInvalid = false;
        $this->assertEquals($expectedInvalid, $actualInvalid);
    }

    public function test_future_date_good()
    {
        $inputGoodFutureDate = '2200-04-16';
        $actualGood = DateService::futureDate($inputGoodFutureDate);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function test_future_date_bad()
    {
        $inputBadFutureDate = '2010-03-05';
        $actualBad = DateService::futureDate($inputBadFutureDate);
        $expectedBad = false;
        $this->assertEquals($expectedBad, $actualBad);
    }

    public function test_future_date_not_date()
    {
        $inputNotDate = 'gloob';
        $actualNotDate = DateService::futureDate($inputNotDate);
        $expectedNotDate = false;
        $this->assertEquals($expectedNotDate, $actualNotDate);
    }

    public function test_available_date_good()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-05-20';
        $fakeAttemptedBooking->end = '2025-05-30';

        $actualGood = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);
    }

    public function test_available_date_bad_start()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-04-20';
        $fakeAttemptedBooking->end = '2025-05-30';
        $actualBadStart = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedBadStart = false;
        $this->assertEquals($expectedBadStart, $actualBadStart);
    }

    public function test_available_date_bad_end()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-03-20';
        $fakeAttemptedBooking->end = '2025-04-30';
        $actualBadEnd = DateService::availableDate($fakeConfirmedBooking, $fakeAttemptedBooking);
        $expectedBadEnd = false;
        $this->assertEquals($expectedBadEnd, $actualBadEnd);
    }
}
