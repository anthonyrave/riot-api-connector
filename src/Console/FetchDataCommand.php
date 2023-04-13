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

    public function handle(): int
    {
        if (! $this->validate()) {
            return 1;
        }
        $this->retrieveLatestVersion();

        $this->fetchDataTypes();

        $this->newLine();
        $this->info('Done');

        return 0;
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
            $this->line('Data to fetch:');
            foreach ($this->dataTypes as $dataType) {
                $this->line('- '.$dataType->value);
            }
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

    private function validate(): bool
    {
        $options = $this->option('data');

        if (empty($options)) {
            $this->fetchAll = true;
            $this->dataTypes = DataTypeEnum::cases();

            return true;
        }

        foreach ($options as $option) {
            $dataType = DataTypeEnum::tryFrom($option);
            if (null === $dataType) {
                $this->error('Data of type "'.$option.'" does not exist.');

                return false;
            }

            $this->dataTypes[] = $dataType;
        }

        return true;
    }
}
