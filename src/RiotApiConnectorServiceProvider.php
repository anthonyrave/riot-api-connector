<?php

namespace Anthonyrave\RiotApiConnector;

use Anthonyrave\RiotApiConnector\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/riot-api-connector.php', 'riot-api-connector');
        }
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/riot-api-connector.php' => config_path('riot-api-connector.php'),
            ], 'riot-api-connector-config');

            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
