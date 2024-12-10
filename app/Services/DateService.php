<?php

namespace App\Services;

use Carbon\Laravel\ServiceProvider;

class DateService extends ServiceProvider
{
    public function validEndDate(string $startDate, string $endDate): bool
    {
        $timestampStart = strtotime($startDate);
        $timestampEnd = strtotime($endDate);

        if ($timestampStart > $timestampEnd) {
            return false;
        } else {
            return true;
        }

    }

    public function futureDate(string $futureDate): bool
    {
        if (time() > strtotime($futureDate))
        {
            return true;
        } else {
            return false;
        }
    }

    public function availableDate(array $confirmedBooking, array $attemptedBooking): bool
    {

    }
}


