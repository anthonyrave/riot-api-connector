<?php

namespace Anthonyrave\RiotApiConnector;

use Anthonyrave\RiotApiConnector\Console\InstallCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/riot-api-connector.php', 'riot-api-connector');
        }
    }

    public function boot(): void
    {
        $this->configureRoutes();

        if (app()->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Configure the routes offered by the application.
     */
    protected function configureRoutes(): void
    {
        Route::group([
            'namespace' => 'Anthonyrave\RiotApiConnector\Http\Controllers',
            'domain' => config('riot-api-connector.domain', null),
            'prefix' => config('riot-api-connector.prefix', 'riot'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        });
    }
}
