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
        $this->info('Riot API connector\'s configurations installed successfully.');
    }
}
