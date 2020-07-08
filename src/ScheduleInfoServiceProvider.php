<?php

namespace LxLang\LaravelScheduleInfo;

use Illuminate\Support\ServiceProvider;

class ScheduleInfoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ScheduleInfoCommand::class,
            ]);
        }
    }
}
