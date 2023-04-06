<?php

namespace RiotApiConnector;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use RiotApiConnector\Console\FetchDataCommand;
use RiotApiConnector\Console\InstallCommand;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Contracts\SummonerFactory;
use RiotApiConnector\Services\SummonerService;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/riot-api-connector.php', 'riot-api-connector');
            $this->mergeConfigFrom(__DIR__.'/../config/data-dragon.php', 'data-dragon');
        }

        Application::macro('setServer', function (string $server) {
            app()['config']->set('riot-api-connector.server', $server);
        });

        $this->app->singleton(
            abstract: RiotApiFactory::class,
            concrete: fn () => new RiotApi(
                baseUri: strval(config('riot-api-connector.url')),
                token: strval(config('riot-api-connector.token'))
            ),
        );

        $this->app->singleton(
            abstract: SummonerFactory::class,
            concrete: fn () => new SummonerService(app(RiotApiFactory::class)),
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
            SummonerFactory::class,
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
