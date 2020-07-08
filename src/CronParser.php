<?php

namespace LxLang\LaravelScheduleInfo;

use Carbon\Carbon;
use Cron\CronExpression;

class CronParser
{
    public function parse(string $expression): CronResult
    {
        $cron = CronExpression::factory($expression);

        return new CronResult(
            $expression,
            Carbon::parse($cron->getNextRunDate(Carbon::now()))
        );
    }
}
