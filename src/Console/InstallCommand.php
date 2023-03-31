<?php

namespace RiotApiConnector\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'riot-api-connector:install';

    /**
     * @var string
     */
    protected $description = 'Installs the Riot API Connector package.';

    public function handle(): void
    {
        $this->addEnvVariable();

        $this->info('Riot API connector installed successfully.');
    }

    /**
     * Appends the "RIOT_API_KEY" environment variable in the .env and .env.example files.
     */
    protected function addEnvVariable(): void
    {
        $envFiles = ['.env', '.env.example'];

        foreach ($envFiles as $envFile) {
            $env = file_get_contents($this->laravel->basePath($envFile));
            if (! str_contains($env, 'RIOT_API_KEY=')) {
                $env .= "\nRIOT_API_KEY=\n";
                file_put_contents($this->laravel->basePath($envFile), $env);
            }
        }
    }
}
