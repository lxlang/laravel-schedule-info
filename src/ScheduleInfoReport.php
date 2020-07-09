<?php

namespace LxLang\LaravelScheduleInfo;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;

class ScheduleInfoReport
{
    private Schedule $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return Collection|ScheduleInfo[]
     */
    public function generate(): Collection
    {
        return collect($this->schedule->events())
            /*
             * Sort by expression, so there is at least some order in the resulting list.
             */
            ->sortBy('expression')
            /*
             * Convert $events to ScheduleInfo Objects for easy usage in other parts of the application.
             */
            ->map(function (Event $event) {
                return ScheduleInfo::fromEvent($event);
            });
    }
}
