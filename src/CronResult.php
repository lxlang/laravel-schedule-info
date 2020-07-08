<?php

namespace LxLang\LaravelScheduleInfo;

use Carbon\Carbon;
use Lorisleiva\CronTranslator\CronTranslator;

class CronResult
{
    private string $expression;
    private Carbon $next;

    public function __construct(string $expression, Carbon $next)
    {
        $this->expression = $expression;
        $this->next = $next;
    }

    /**
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * @return Carbon
     */
    public function getNext(): Carbon
    {
        return $this->next;
    }

    public function getTranslation()
    {
        return CronTranslator::translate($this->expression);
    }
}
