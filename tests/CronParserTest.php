<?php

namespace LxLang\LaravelScheduleInfo\Tests;

use Carbon\Carbon;
use LxLang\LaravelScheduleInfo\CronParser;
use LxLang\LaravelScheduleInfo\CronResult;
use PHPUnit\Framework\TestCase;

class CronParserTest extends TestCase
{
    public function testParse()
    {
        Carbon::setTestNow(
            Carbon::create(2020, 1, 1, 13, 42, 32)
        );

        $parser = new CronParser();
        $result = $parser->parse("* * * * *");

        self::assertInstanceOf(CronResult::class, $result);
        self::assertEquals("* * * * *", $result->getExpression(), 'Cronexpression was altered.');
        self::assertEquals(
            28,
            $result->getNext()->diffInSeconds(),
            'Due on next minute was not detected.'
        );
        self::assertEquals('Every minute', $result->getTranslation());
    }
}
