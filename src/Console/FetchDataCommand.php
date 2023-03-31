<?php

namespace RiotApiConnector\Console;

use Illuminate\Console\Command;
use RiotApiConnector\Enums\DataTypeEnum;
use RiotApiConnector\Facades\DataDragon;

class FetchDataCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'riot-api-connector:fetch
                            {--data=* : Data types you would like to fetch (leaving blank will fetch all data types)}';

    /**
     * @var string
     */
    protected $description = 'Fetches the data with DataDragon for the specified data types (only champions for the moment).';

    public function handle(): void
    {
        $options = $this->option('data');

        if (empty($options)) {
            $this->fetchAllDataTypes();
        } else {
            $this->fetchDataTypes($options);
        }
    }

    private function fetchAllDataTypes(): void
    {
        $this->info('Fetching all data...');

        foreach (DataTypeEnum::cases() as $dataTypeEnum) {
            $this->fetchDataType($dataTypeEnum);
        }
    }

    private function fetchDataType(DataTypeEnum $dataType): void
    {
        $this->info('Fetching data of type '.$dataType->value.'...');
        DataDragon::driver($dataType->value)->update();
    }

    private function fetchDataTypes(array $options): void
    {
        foreach ($options as $option) {
            $dataType = DataTypeEnum::tryFrom($option);

            if ($dataType === null) {
                $this->error('Data of type "'.$option.'" does not exist.');

                return;
            }

            $this->fetchDataType($dataType);
        }
    }
}
