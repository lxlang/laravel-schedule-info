<?php

namespace LxLang\LaravelScheduleInfo\Command;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use LxLang\LaravelScheduleInfo\CronParser;
use LxLang\LaravelScheduleInfo\ScheduleInfoReport;

class ScheduleInfoCommand extends Command
{
    protected $signature = 'schedule:info';
    protected $description = 'Displays configured command schedule.';
    private ScheduleInfoReport $report;

    public function __construct(ScheduleInfoReport $report)
    {
        parent::__construct();
        $this->report = $report;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scheduledCommands = $this->report->generate();

        $this->table(
            array_keys($scheduledCommands->first()->toArray()),
            $scheduledCommands
        );

        return;
    }
}
