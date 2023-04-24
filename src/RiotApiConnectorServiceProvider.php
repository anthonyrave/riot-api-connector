<?php

namespace RiotApiConnector;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use RiotApiConnector\Console\FetchDataCommand;
use RiotApiConnector\Console\InstallCommand;
use RiotApiConnector\Console\UpdateApiKeyCommand;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\MasteryRepository;
use RiotApiConnector\Repositories\SummonerRepository;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/riot.php', 'riot');
            $this->mergeConfigFrom(__DIR__.'/../config/data_dragon.php', 'data_dragon');
            $this->mergeConfigFrom(__DIR__.'/../config/riot_api_connector.php', 'riot_api_connector');
        }

        $this->app->singleton(
            abstract: RiotApiFactory::class,
            concrete: fn () => new RiotApi()
        );

        $this->app->singleton(
            abstract: DataDragonFactory::class,
            concrete: fn ($app) => new DataDragonManager($app)
        );

        $this->app->bind(
            abstract: PendingRequest::class,
            concrete: fn ($app) => new PendingRequest()
        );

        $this->app->bind(
            abstract: SummonerRepository::class,
            concrete: fn ($app) => new SummonerRepository(
                $app->make(PendingRequest::class),
                Summoner::query()
            )
        );

        $this->app->bind(
            abstract: MasteryRepository::class,
            concrete: fn ($app) => new MasteryRepository(
                $app->make(PendingRequest::class),
                Mastery::query()
            )
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

        App::macro('disableRiotApiConnectorCache', function () {
            $this->app['config']->set('riot_api_connector.cache.enabled', false);
        });

        if (app()->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                FetchDataCommand::class,
                UpdateApiKeyCommand::class,
            ]);
        }
    }
}
