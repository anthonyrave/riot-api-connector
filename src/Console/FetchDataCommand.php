<?php

namespace RiotApiConnector\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use RiotApiConnector\Enums\DataTypeEnum;
use RiotApiConnector\Facades\DataDragon;

class FetchDataCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'riot-api-connector:fetch
                            {--data=* : Data types (leave blank to fetch all)}';

    /**
     * @var string
     */
    protected $description = 'Fetches the data with DataDragon for the specified data types.';

    /**
     * Version used to retrieve the data
     */
    private string $version;

    public function handle(): void
    {
        $this->retrieveLatestVersion();

        $options = $this->option('data');

        if (empty($options)) {
            $this->fetchAllDataTypes();
        } else {
            $this->fetchDataTypes($options);
        }
        $this->newLine();
        $this->info('Done');
    }

    private function fetchAllDataTypes(): void
    {
        $this->line('Fetch all data types');
        $this->withProgressBar(DataTypeEnum::cases(), function ($dataTypeEnum) {
            $this->fetchDataType($dataTypeEnum);
        });
    }

    private function fetchDataType(DataTypeEnum $dataType): void
    {
        DataDragon::driver($dataType->value)->update($this->version);
    }

    private function fetchDataTypes(array $options): void
    {
        $this->line('Fetch '.implode(', ', $options));
        $this->withProgressBar($options, function ($option) {
            $dataType = DataTypeEnum::tryFrom($option);

            if ($dataType === null) {
                $this->error('Data of type "'.$option.'" does not exist.');

                return;
            }

            $this->fetchDataType($dataType);
        });
    }

    private function retrieveLatestVersion(): void
    {
        $this->info('Retrieving latest version...');
        $this->version = Http::get(config('data_dragon.data.versions'))->json()[0];
        $this->comment($this->version);
        $this->newLine();
    }
}
