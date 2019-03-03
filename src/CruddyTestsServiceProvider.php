<?php

namespace Modulero\CruddyTests;

use Illuminate\Support\ServiceProvider;
use Modulero\CruddyTests\CruddyTestsCommand;

class CruddyTestsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'cruddy-tests'
        );

        $this->commands([
            CruddyTestsCommand::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('cruddy-tests.php'),
            ], 'config');
        }
    }
}
