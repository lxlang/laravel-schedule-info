<?php

namespace LxLang\LaravelScheduleInfo;

use Ahc\Cron\Expression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Lorisleiva\CronTranslator\CronTranslator;

class ScheduleInfoCommand extends Command
{
    protected $signature = 'schedule:info';
    protected $description = 'Displays configured command schedule.';

    private Schedule $schedule;

    private CronParser $cronParser;

    public function __construct(Schedule $schedule, CronParser $cronParser)
    {
        parent::__construct();
        $this->schedule = $schedule;
        $this->cronParser = $cronParser;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scheduledCommands = collect($this->schedule->events())
            ->map(function (Event $event) {
                $cron = $this->cronParser->parse($event->expression);

                return [
                    'expression' => $cron->getExpression(),
                    'command' => static::formatCommand($event->command),
                    'when' => $cron->getTranslation(),
                    'next_due' => $cron->getNext(),
                ];
            })
            /*
             * Sort by expression, so there is at least some order in the resulting list.
             */
            ->sortBy('expression');

        $this->table(
            array_keys($scheduledCommands->first()),
            $scheduledCommands
        );

        return;
    }

    /**
     * If it's an artisan command, strip off the PHP
     *
     * @param $command
     * @return string
     */
    protected static function formatCommand(string $command): string
    {
        $parts = explode(' ', $command);

        if (count($parts) > 2 && $parts[1] === "'artisan'") {
            array_shift($parts);
            array_shift($parts);
        }

        return implode(' ', $parts);
    }
}
