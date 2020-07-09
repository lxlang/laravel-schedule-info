<?php

namespace LxLang\LaravelScheduleInfo\Tests;

use Carbon\Carbon;
use LxLang\LaravelScheduleInfo\ScheduleInfo;
use PHPUnit\Framework\TestCase;

class ScheduleInfoTest extends TestCase
{
    /**
     * @covers \LxLang\LaravelScheduleInfo\ScheduleInfo
     */
    public function testScheduleInfo()
    {
        Carbon::setTestNow(
            Carbon::create(2020, 1, 1, 13, 42, 32)
        );

        $info = new ScheduleInfo(
            "* * * * *",
            ' php artisan hello:world'
        );

        self::assertEquals("* * * * *", $info->getExpression(), 'Cronexpression was altered.');
        self::assertEquals(
            28,
            $info->getNext()->diffInSeconds(),
            'Due on next minute was not detected.'
        );
        self::assertEquals('Every minute', $info->getTranslation());
    }
}
