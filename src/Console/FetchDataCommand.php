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

    private bool $fetchAll = false;

    public function handle(): void
    {
        $this->validateOptions();
        $this->retrieveLatestVersion();

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
        if ($this->fetchAll) {
            $this->line('Fetch all data types');
        } else {
            $this->line('Fetch '.implode(', ', $this->dataTypes));
        }
        $this->withProgressBar($this->dataTypes, function ($dataType) {
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
            $this->fetchAll = true;
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
