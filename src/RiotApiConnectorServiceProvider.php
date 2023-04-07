<?php

namespace RiotApiConnector;

use Illuminate\Support\ServiceProvider;
use RiotApiConnector\Console\FetchDataCommand;
use RiotApiConnector\Console\InstallCommand;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Contracts\RiotApiFactory;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/riot_api_connector.php', 'riot_api_connector');
            $this->mergeConfigFrom(__DIR__.'/../config/data_dragon.php', 'data_dragon');
        }

        $this->app->singleton(
            abstract: DataDragonFactory::class,
            concrete: fn ($app) => new DataDragonManager($app)
        );
    }

    public function provides(): array
    {
        return [
            DataDragonFactory::class,
            RiotApiFactory::class,
        ];
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if (app()->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                FetchDataCommand::class,
            ]);
        }
    }
}
