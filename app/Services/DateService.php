<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Laravel\ServiceProvider;

class DateService extends ServiceProvider
{
    public function validEndDate(string $startDate, string $endDate): bool
    {
        $timestampStart = strtotime($startDate);
        $timestampEnd = strtotime($endDate);
//  $timestampStart > $timestampEnd ? false : true;
//        return $timestampStart < $timestampEnd;
        if ($timestampStart > $timestampEnd) {
            return false;
        } else {
            return true;
        }
    }

    public function futureDate(string $futureDate): bool
    {
//        time() > strtotime($futureDate) ? true : false;
//        return time() > strtotime($futureDate);
        if (time() > strtotime($futureDate))
        {
            return true;
        } else {
            return false;
        }
    }

    public function availableDate(Booking $confirmedBooking, Booking $attemptedBooking): bool
    {
        $confirmedStart = strtotime($confirmedBooking->start);
        $confirmedEnd = strtotime($confirmedBooking->end);
        $attemptedStart = strtotime($attemptedBooking->start);
        $attemptedEnd = strtotime($attemptedBooking->end);

        if ($attemptedStart > $confirmedStart && $attemptedStart < $confirmedEnd)
        {
            return false;
        } else if ($attemptedEnd > $confirmedStart && $attemptedEnd < $confirmedEnd)
        {
            return false;
        } else {
            return true;
        }
    }
}
