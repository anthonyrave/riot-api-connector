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

    private array $dataTypes;

    public function handle(): void
    {
        $this->retrieveLatestVersion();

        $this->validateOptions();

        $this->fetchDataTypes();

        $this->newLine();
        $this->info('Done');
    }

    private function fetchDataType(DataTypeEnum $dataType): void
    {
        DataDragon::driver($dataType->value)->update($this->version);
    }

    private function fetchDataTypes(): void
    {
        $this->line('Fetch '.implode(', ', $this->dataTypes));
        $this->withProgressBar($this->dataTypes, function ($dataType) {
            $dataType = DataTypeEnum::tryFrom($dataType);

            if ($dataType === null) {
                $this->error('Data of type "'.$dataType.'" does not exist.');

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

    private function validateOptions(): void
    {
        $options = $this->option('data');

        if (empty($options)) {
            $this->line('Fetch all data types');
            $this->dataTypes = DataTypeEnum::cases();
            return;
        }

        foreach ($options as $option) {
            if (null === DataTypeEnum::tryFrom($option)) {
                $this->error('Data of type "'.$option.'" does not exist.');
                exit(1);
            }

            $this->dataTypes[] = $option;
        }
    }
}
