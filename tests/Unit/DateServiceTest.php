<?php

namespace Tests\Unit;

use App\Services\DateService;
use PHPUnit\Framework\TestCase;

class DateServiceTest extends TestCase
{
    public function testValidEndDate()
    {
        $inputStartDate = 2025-04-15;
        $inputEndDate = 2025-04-30;

    }

    public function testFutureDate()
    {
        $inputGoodFutureDate = '2025-04-16';
        $inputBadFutureDate = '2010-03-05';
        $inputNotDate = 'gloob';

        $actualGood = DateService::futureDate($inputGoodFutureDate);
        $expectedGood = true;
        $this->assertEquals($expectedGood, $actualGood);

        $actualBad = DateService::futureDate($inputBadFutureDate);
        $expectedBad = false;
        $this->assertEquals($expectedBad, $actualBad);

        $actualNotDate = DateService::futureDate($inputNotDate);
        $expectedNotDate = false;
        $this->assertEquals($expectedNotDate, $actualNotDate);

    }

    public function testAvailableDate()
    {

    }
}
