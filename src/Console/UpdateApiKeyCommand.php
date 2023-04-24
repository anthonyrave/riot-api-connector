<?php

namespace RiotApiConnector\Console;

use Illuminate\Console\Command;

class UpdateApiKeyCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'riot-api-connector:key {key? : Your previously generated key}';

    /**
     * @var string
     */
    protected $description = 'Update the RIOT_API_KEY variable in the .env file.';

    public function handle(): int
    {
        if (! $key = $this->argument('key')) {
            $this->line('You can generate an API key on https://developer.riotgames.com/');
            $this->newLine();
            $key = $this->secret('API key');
        }

        if (! str_contains($key, 'RGAPI-') || strlen($key) !== 42) {
            $this->error('Key ['.$key.'] is not a valid Riot games\' API key.');
            return 1;
        }

        $env = $this->laravel->basePath('.env');

        if (! file_exists($env)) {
            $this->error('No ".env" file found.');
            return 1;
        }

        $content = preg_replace(
            '/RIOT_API_KEY=([a-zA-Z0-9\-]*)/',
            'RIOT_API_KEY='.$key,
            file_get_contents($env)
        );

        if (! file_put_contents($env, $content)) {
            $this->error('An error happened while updating your API key.');
            return 1;
        }

        $this->info('API key successfully updated');
        return 0;
    }
}
