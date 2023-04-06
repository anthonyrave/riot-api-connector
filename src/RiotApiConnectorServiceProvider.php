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
            $this->mergeConfigFrom(__DIR__.'/../config/riot-api-connector.php', 'riot-api-connector');
            $this->mergeConfigFrom(__DIR__.'/../config/data-dragon.php', 'data-dragon');
        }

        $this->app->singleton(
            abstract: RiotApiFactory::class,
            concrete: fn () => new RiotApi(
                baseUri: strval(config('riot-api-connector.url')),
                token: strval(config('riot-api-connector.token'))
            ),
        );

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
