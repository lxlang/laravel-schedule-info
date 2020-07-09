<?php

namespace LxLang\LaravelScheduleInfo;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Support\Arrayable;
use Lorisleiva\CronTranslator\CronTranslator;

class ScheduleInfo implements Arrayable
{

    private string $command;
    private string $expression;

    public function __construct(string $expression, string $command)
    {
        $this->expression = $expression;
        $this->command = $this->formatCommand(
            $command
        );
    }

    public static function fromEvent(Event $event): ScheduleInfo
    {
        return new static(
            $event->expression,
            $event->command
        );
    }

    /**
     * Get raw cron-expression.
     *
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }


    /**
     * Get command with parameters.
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Get cron as parsed expression.
     *
     * @return CronExpression
     */
    private function getCron(): CronExpression
    {
        return CronExpression::factory($this->expression);
    }

    /**
     * Remove `php artisan` from command string, leaving only the command name and parameters.
     *
     * @param $command
     * @return string
     */
    private function formatCommand(string $command): string
    {
        $parts = explode(' ', $command);

        if (count($parts) > 2 && $parts[1] === "'artisan'") {
            array_shift($parts);
            array_shift($parts);
        }

        return implode(' ', $parts);
    }

    /**
     * Get the next due date of this schedule as Carbon.
     *
     * @return Carbon
     */
    public function getNext(): Carbon
    {
        return Carbon::parse(
            $this
                ->getCron()
                ->getNextRunDate(Carbon::now())
        );
    }


    /**
     * Get a human readable translation of the next execution for this schedule.
     * @return string
     * @throws \Lorisleiva\CronTranslator\CronParsingException
     */
    public function getTranslation(): string
    {
        return CronTranslator::translate($this->expression);
    }

    /**
     * Get an array representation of this object.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'expression' => $this->getExpression(),
            'command' => $this->getCommand(),
            'translation' => $this->getTranslation(),
            'next' => $this->getNext(),
        ];
    }
}
