<?php

namespace LxLang\LaravelScheduleInfo;

use Illuminate\Support\ServiceProvider;

class ScheduleInfoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(
            'command.schedule.info',
            ScheduleInfoCommand::class
        );

        $this->commands(
            'command.schedule.info'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.schedule.info'];
    }
}
