<?php

namespace Anthonyrave\RiotApiConnector\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'riot-api-connector:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Riot API Connector configs';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->callSilent('vendor:publish', ['--tag' => 'riot-api-connector-config', '--force' => true]);
        $this->addEnvVariable();
        $this->info('Riot API connector\'s configurations installed successfully.');
    }

    /**
     * @return void
     */
    protected function addEnvVariable(): void
    {
        $envFiles = ['.env', '.env.example'];

        foreach ($envFiles as $envFile) {
            $env = file_get_contents($this->laravel->basePath($envFile));
            if(!str_contains($env, 'RIOT_API_KEY=')) {
                $env .= "\nRIOT_API_KEY=\n";
                file_put_contents($this->laravel->basePath($envFile), $env);
            }
        }
    }
}
