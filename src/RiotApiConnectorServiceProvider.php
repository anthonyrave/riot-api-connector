<?php

namespace RiotApiConnector;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use RiotApiConnector\Adapters\MasteryAdapter;
use RiotApiConnector\Adapters\SummonerAdapter;
use RiotApiConnector\Console\FetchDataCommand;
use RiotApiConnector\Console\InstallCommand;
use RiotApiConnector\Console\UpdateApiKeyCommand;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Contracts\RiotApiFactory;
use RiotApiConnector\Http\Requests\PendingRequest;
use RiotApiConnector\Models\Champion\Champion;
use RiotApiConnector\Models\Mastery;
use RiotApiConnector\Models\Region;
use RiotApiConnector\Models\Summoner;
use RiotApiConnector\Repositories\MasteryRepository;
use RiotApiConnector\Repositories\SummonerRepository;

class  RiotApiConnectorServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RiotApiFactory::class => RiotApi::class,
        DataDragonFactory::class => DataDragonManager::class,
    ];

    public function register(): void
    {
        if (!app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/riot.php', 'riot');
            $this->mergeConfigFrom(__DIR__ . '/../config/data_dragon.php', 'data_dragon');
            $this->mergeConfigFrom(__DIR__ . '/../config/riot_api_connector.php', 'riot_api_connector');
        }

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

        $this->app->bind(
            abstract: SummonerAdapter::class,
            concrete: fn ($app) => new SummonerAdapter($app->getRegion())
        );

        $this->app->bind(
            abstract: MasteryAdapter::class,
            concrete: fn ($app, array $params) => new MasteryAdapter($params['summoner'] ?? null, null)
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->registerMacros();

        if (app()->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                FetchDataCommand::class,
                UpdateApiKeyCommand::class,
            ]);
        }
    }

    public function registerMacros(): void
    {
        App::macro('disableRiotApiConnectorCache', function () {
            $this->app['config']->set('riot_api_connector.cache.enabled', false);
        });

        App::macro('getRegion', function () {
            return Region::whereName($this['config']->get('riot_api_connector.region'))->first();
        });

        App::macro('setRegion', function (string|Region $region) {
            $this['config']->set(
                'riot_api_connector.region',
                $region instanceof Region
                    ? $region->name
                    : $region
            );
        });
    }
}
