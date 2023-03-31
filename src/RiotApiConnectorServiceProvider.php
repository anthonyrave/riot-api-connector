<?php

namespace RiotApiConnector;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use RiotApiConnector\Console\FetchDataCommand;
use RiotApiConnector\Console\InstallCommand;
use RiotApiConnector\Contracts\DataDragonFactory;
use RiotApiConnector\Services\RiotApiService;

class RiotApiConnectorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/riot-api-connector.php', 'riot-api-connector');
            $this->mergeConfigFrom(__DIR__.'/../config/data-dragon.php', 'data-dragon');
        }

        $this->app->singleton(
            abstract: RiotApiService::class,
            concrete: fn () => new RiotApiService(
                baseUrl: strval(config('riot-api-connector.url')),
                apiToken: strval(config('riot-api-connector.token'))
            ),
        );

        $this->app->singleton(
            abstract: DataDragonFactory::class,
            concrete: fn ($app) => new DataDragonManager($app)
        );
    }

    public function provides(): array
    {
        return [DataDragonFactory::class];
    }

    public function boot(): void
    {
        $this->configureRoutes();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if (app()->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                FetchDataCommand::class,
            ]);
        }
    }

    /**
     * Configure the routes offered by the application.
     */
    protected function configureRoutes(): void
    {
        Route::group([
            'namespace' => 'RiotApiConnector\Http\Controllers',
            'domain' => config('riot-api-connector.domain'),
            'prefix' => config('riot-api-connector.prefix', 'riot'),
        ], fn () => $this->loadRoutesFrom(__DIR__.'/../routes/routes.php'));
    }
}
