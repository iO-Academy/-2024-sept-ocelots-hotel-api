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
        $actualGood = DateService::isEndDateValid($inputStartDate, $inputEndDate);
        $this->assertTrue($actualGood);
    }

    public function test_valid_end_date_bad()
    {
        $inputStartDate = '2025-04-15';
        $inputEndDate = '2024-04-30';
        $actualBad = DateService::isEndDateValid($inputStartDate, $inputEndDate);
        $this->assertFalse($actualBad);
    }

    public function test_valid_end_date_invalid()
    {
        $inputStartDate = 'no';
        $inputEndDate = 'whelp';
        $actualInvalid = DateService::isEndDateValid($inputStartDate, $inputEndDate);
        $this->assertFalse($actualInvalid);
    }

    public function test_future_date_good()
    {
        $inputGoodFutureDate = '2200-04-16';
        $actualGood = DateService::isDateInTheFuture($inputGoodFutureDate);
        $this->assertTrue($actualGood);
    }

    public function test_future_date_bad()
    {
        $inputBadFutureDate = '2010-03-05';
        $actualBad = DateService::isDateInTheFuture($inputBadFutureDate);
        $this->assertFalse($actualBad);
    }

    public function test_future_date_not_date()
    {
        $inputNotDate = 'gloob';
        $actualNotDate = DateService::isDateInTheFuture($inputNotDate);
        $this->assertFalse($actualNotDate);
    }

    public function test_available_date_good()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-05-20';
        $fakeAttemptedBooking->end = '2025-05-30';

        $actualGood = DateService::isDateAvailable($fakeConfirmedBooking, $fakeAttemptedBooking);
        $this->assertTrue($actualGood);
    }

    public function test_available_date_bad_start()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-04-20';
        $fakeAttemptedBooking->end = '2025-05-30';
        $actualBadStart = DateService::isDateAvailable($fakeConfirmedBooking, $fakeAttemptedBooking);
        $this->assertFalse($actualBadStart);
    }

    public function test_available_date_bad_end()
    {
        $fakeConfirmedBooking = new Booking;
        $fakeAttemptedBooking = new Booking;
        $fakeConfirmedBooking->start = '2025-04-15';
        $fakeConfirmedBooking->end = '2025-04-30';
        $fakeAttemptedBooking->start = '2025-03-20';
        $fakeAttemptedBooking->end = '2025-04-30';
        $actualBadEnd = DateService::isDateAvailable($fakeConfirmedBooking, $fakeAttemptedBooking);
        $this->assertFalse($actualBadEnd);
    }
}
